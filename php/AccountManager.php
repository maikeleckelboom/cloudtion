<?php
class AccountManager {
    private const ACCOUNTS_FILENAME = 'accounts.json';
    private const ALLOWED_EMAIL_DOMAINS = ['deltion.nl', 'st.deltion.nl'];

    public $currentUser;

    public function __construct() {
        // Start de sessie.
        session_start();

        // Dit even op false zetten, zodat we weten dat de gebruiker niet is ingelogd.
        if (!isset($_SESSION['logged_in'])) {
            $_SESSION['logged_in'] = false;
        }

        // Als de gebruiker is ingelogd.
        if ($_SESSION['logged_in']) {
            if (!isset($_SESSION['logged_in']->email))
                $this->logout('logout_error');

            // Verkrijg de huidige gebruiker.
            $this->currentUser = $this->getUser($_SESSION['logged_in']->email);

            // Uitloggen als de gebruiker niet bestaat / email is veranderd.
            if (!$this->currentUser)
                $this->logout('logout_error');

            // Uitloggen als het wachtwoord van de gebruiker is veranderd.
            if ($this->hasPasswordBeenChangedDuringSession())
                $this->logout('logout_pass');

            // Uitloggen als de gebruiker zijn e-mailadres niet heeft geverifieerd.
            if (!$this->currentUser->email_verified)
                $this->logout('logout_error');
        }
    }

    public function logout(string $reason = 'logout') {
        // Destroy de sessie.
        session_destroy();
        header("Location: login?$reason");
        exit;
    }

    // Deze functie kan bovenaan een pagina worden gezet. Het leidt de gebruiker om naar de loginpagina als de gebruiker
    // niet is ingelogd.
    public function requireLogin() {
        if (!$_SESSION['logged_in']) {
            if ($_SERVER['REQUEST_URI'] !== '/logout') {
                header('Location: login?redirect=' . base64_encode($_SERVER['REQUEST_URI']));
            } else {
                header('Location: login?not_logged_in');
            }
            exit;
        }
    }

    // Deze functie kan bovenaan een pagina worden gezet. Het leidt de gebruiker om naar het dashboard als de gebruiker
    // al is ingelogd.
    public function requireLoggedOut() {
        if ($_SESSION['logged_in']) {
            header('Location: dashboard');
            exit;
        }
    }

    public function register(string $firstName, string $lastName, string $email, string $password, string $passwordagain) {
        // Kijk of alles is ingevuld.
        if (empty($firstName) || 
            empty($lastName) || 
            empty($email) || 
            empty($password) || 
            empty($passwordagain))
            return 'Alle velden moeten worden ingevuld.';

        // Kijk d.m.v. reguliere expressies of de voor- en achternaam voldoen aan de juiste criteria.
        if(preg_match('/^[a-zA-Z\sàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/', $firstName) < 1) 
            return 'De voornaam bevat karakters die niet zijn toegestaan.';
        if(preg_match('/^[a-zA-Z\sàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/', $lastName) < 1) 
            return 'De achternaam bevat karakters die niet zijn toegestaan.';

        // Kijk of het wachtwoord doet aan de juiste criteria. Er is alleen een minimale lengte.
        // Waarom je überhaupt een wachtwoord nog verder zou limiteren is mij een raadsel. 
        if (strlen($password) < 2)
            return 'Je wachtwoord moet ten minste 2 karakters lang zijn.';

        // Kijk of beide ingevoerde wachtwoorden overeenkomen.
        if ($password !== $passwordagain)
            return 'De wachtwoorden komen niet overeen.';

        // Kijk of het ingevoerde e-mailadres een geldig e-mailadres is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return 'Het ingevoerde e-mailadres is niet geldig.';

        // Kijk of het domein van de ingevoerde e-mailadres in de "whitelist" staat.
        $parts = explode('@', $email);
        $domain = array_pop($parts);
        if (!in_array($domain, $this::ALLOWED_EMAIL_DOMAINS))
            return 'Het ingevoerde e-mailadres is geen geldig Deltion e-mailadres.';

        // Kijk of er al een gebruiker bestaat met dit e-mailadres.
        if ($this->getUser($email))
            return 'Er bestaat al een account met dit e-mailadres.';
        
        // Hash het wachtwoord.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Maak een e-mail verificatiecode aan.
        $email_verification_token = $this->generateRandomString(16);

        // Maak het account aan.
        $acc = $this->readAccounts();
        $user = new stdClass();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->password = $hashed_password;
        $user->email_verification_token = password_hash($email_verification_token, PASSWORD_DEFAULT);
        $user->email_verified = false;
        $acc[] = $user;
        if (!$this->saveAccounts($acc))
            return 'Er is iets foutgegaan tijdens het aanmaken van je account. Probeer het later opnieuw.';

        // TODO: Hier moet nog een e-mail worden verzonden om de gebruiker te kunnen verifiëren.

        // Vertel de gebruiker op het login scherm dat de registratie compleet is.
        header('Location: login?register_complete&' . $email_verification_token); // TODO: Token hier weghalen.
        exit;
    }

    public function login(string $email, string $password) {
        // Kijk of alles is ingevuld.
        if (empty($email) || empty($password))
            return 'Alle velden moeten worden ingevuld.';

        // Kijk of het ingevoerde e-mailadres geldig is.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return 'Het ingevoerde e-mailadres is niet geldig.';
        
        // Verkrijg de gebruiker. Als de gebruiker niet bestaat, geef dan een foutmelding.
        $user = $this->getUser($email);
        if (!$user)
            return 'Er bestaat geen account met dat e-mailadres.';

        // Verifieer het ingevoerde wachtwoord van de gebruiker.
        $logged_in = password_verify($password, $user->password);
        if (!$logged_in)
            return 'Het opgegeven wachtwoord is onjuist.';

        // Geef een foutmelding als het e-mailadres van de gebuiker nog niet is geverifieerd.
        if (!$user->email_verified)
            return 'Het e-mailadres geassocieerd met dit account is nog niet geverifieerd.'; 

        // Verwijder de password reset key als de gebruiker inlogt.
        if (isset($user->password_reset)) {
            unset($user->password_reset);
            $this->updateUser($user);
        }

        // Hier is de gebruiker ingelogd.
        $_SESSION['logged_in'] = new stdClass();
        $_SESSION['logged_in']->email = $user->email;
        $_SESSION['logged_in']->password_check = sha1($user->password);

        // Gebruiker wordt omgeleid naar het dashboard.
        header('Location: dashboard');
        exit;
    }

    public function verifyEmail(string $token, string $email) {
        // Verkrijg de gebruiker.
        $user = $this->getUser($email);
        if (!$user) {
            header('Location: login?email_not_verified');
            exit;
        }

        // Je kan niet twee keer je e-mailadres verifiëren.
        if ($user->email_verified)
            return false;

        // Kijk of de opgegeven "token" overeenkomt.
        if (!password_verify($token, $user->email_verification_token))
            return false;

        // De gebruiker heeft hier zijn e-mailadres geverifieerd.
        $user->email_verified = true;
        unset($user->email_verification_token);
        if ($this->updateUser($user)) {
            header('Location: login?email_verified');
            exit;
        }
    }

    public function forgotPassword(string $email) {
        // Verkrijg de gebruiker.
        $user = $this->getUser($email);
        if (!$user)
            return 'Er bestaat geen gebruiker met dat e-mailadres.';

        // Update de gebruiker met een unieke password reset key.
        $password_reset_token = $this->generateRandomString(16);
        $user->password_reset = new stdClass();
        $user->password_reset->token = password_hash($password_reset_token, PASSWORD_DEFAULT);
        $user->password_reset->request_date = time();
        $this->updateUser($user);

        // TODO: Verzend een e-mail met de reset key.

        header('Location: reset-password?request_complete&' . $password_reset_token); // TODO: Token hier weghalen.
        exit;
    }

    public function changeCurrentUserPassword(string $currentpassword, string $newpassword, string $newpasswordval) {
        // Kijk of de huidige gebruiker is ingelogd.
        if (!$this->currentUser)
            return 'Je bent niet ingelogd.';

        // Kijk of het huidige wachtwoord klopt.
        $verified = password_verify($currentpassword, $this->currentUser->password);
        if (!$verified)
            return 'Je huidige wachtwoord klopt niet.';

        // Kijk of de nieuwe wachtwoorden overeen komen.
        if ($newpassword !== $newpasswordval)
            return 'Je nieuwe wachtwoord komt niet overeen.';

        // Kijk of de nieuwe wachtwoorden overeen komen.
        if ($currentpassword === $newpassword)
            return 'Het nieuwe wachtwoord is hetzelfde als het oude wachtwoord.';

        // Update de gebruiker.
        $this->currentUser->password = password_hash($newpassword, PASSWORD_DEFAULT);
        $this->updateUser($this->currentUser);

        // Uitloggen.
        $this->logout('pass_change');
    }

    public function changeUserPasswordWithKey(string $key, string $email, string $newpassword, string $newpasswordval) {
        $email = base64_decode($email);

        // Verkrijg de gebruiker.
        $user = $this->getUser($email);
        if (!$user)
            return 'Er bestaat geen gebruiker met dit e-mailadres.';

        // Kijk of de gebruiker überhaupt een reset heeft aangevraagd.
        if (!isset($user->password_reset))
            return 'Kan wachtwoord niet resetten. De link is niet geldig.';

        // Kijk of het mag. Misschien dit kopiëren naar een aparte functie zodat de gebruiker wordt omgeleid naar de loginpagina.
        if (!password_verify($key, $user->password_reset->token)) 
            return 'Kan wachtwoord niet resetten. De link is niet geldig.';
        if (time() > ($user->password_reset->request_date + (60 * 30)))
            return 'Kan wachtwoord niet resetten. De link is verlopen.';

        // Kijk of de nieuwe wachtwoorden overeen komen.
        if ($newpassword !== $newpasswordval)
            return 'Je nieuwe wachtwoord komt niet overeen.';

        // Update de gebruiker.
        $user->password = password_hash($newpassword, PASSWORD_DEFAULT);
        // Wachtwoord is gereset. Maak de token ongeldig.
        unset($user->password_reset);
        if (!$this->updateUser($user))
            return 'Kan wachtwoord niet veranderen door een fout in het systeem.';

        // Uitloggen. Is eigenlijk niet nodig, maar dit gaat gewoon naar de loginpagina.
        $this->logout('pass_change');
    }

    private function generateRandomString(int $length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function saveAccounts($newAccounts) {
        $ptr = fopen($this::ACCOUNTS_FILENAME, "w+");
        $time = 0;
        while (!flock($ptr, LOCK_EX)) {
            sleep(1);
            if ($time++ > 15) // Timeout van 15 seconden.
                return false;
        }
        fwrite($ptr, json_encode($newAccounts, JSON_PRETTY_PRINT));
        fclose($ptr);
        return true;
    }

    private function readAccounts() {
        if (!file_exists($this::ACCOUNTS_FILENAME))
            return [];

        $file = file_get_contents($this::ACCOUNTS_FILENAME);
        return json_decode($file);
    }

    private function getUser(string $email) {
        $users = $this->readAccounts();
        foreach ($users as $user) {
            if ($user->email == $email)
                return $user;
        }
        return false;
    }

    private function updateUser($updated_user) {
        $users = $this->readAccounts();
        for ($i = 0; $i < sizeof($users); $i++) { 
            if ($users[$i]->email == $updated_user->email) {
                $users[$i] = $updated_user;
                $this->saveAccounts($users);
                return true;
            }
        }
        return false;
    }

    private function hasPasswordBeenChangedDuringSession() {
        if (!$_SESSION['logged_in'] || !isset($_SESSION['logged_in']->password_check))
            return false;

        // Uitloggen als het wachtwoord waarmee is ingelogd niet overeenkomt met het huidige wachtwoord van de gebruiker.
        return !($_SESSION['logged_in']->password_check === sha1($this->currentUser->password));
    }
}