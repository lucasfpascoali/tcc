<?php

use Source\Core\Message;
use Source\Core\Session;


/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */


/**
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);

}

function is_cpf(string $cpf): bool
{
    if (strlen($cpf) != 11 || !is_numeric($cpf)) {
        return false;
    }
    return true;
}

/**
 * @param string $passwd
 * @return bool
 */
function is_passwd(string $passwd): bool
{
    if (password_get_info($passwd)['algo']) {
        return true;
    }

    return (mb_strlen($passwd) >= CONF_PASSWD_MIN_LEN && mb_strlen($passwd) <= CONF_PASSWD_MAX_LEN);
}

/**
 * @param string $password
 * @return string
 */
function passwd(string $password): string
{
    return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTIONS);
}

/**
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * @param string $hash
 * @return bool
 */
function passwd_needs_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTIONS);
}

/**
 * @return string
 */
function csrf_input(): string
{
    session()->csrf();
    return "<input type='hidden' name='csrf' value='" . (session()->csrf_token ?? "") . "' />";
}

/**
 * @param $request
 * @return bool
 */
function csrf_verify($request): bool
{
    if (empty(session()->csrf_token) || empty($request['csrf']) || session()->csrf_token != $request['csrf']) {
        return false;
    }
    return true;
}


/**
 * ##################
 * ###   STRING   ###
 * ##################
 */


/**
 * @param string $string
 * @return string
 */
function str_slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats = 'ÀÁÂÄÅÃÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝŸþßàáâãäåæçèéêëìíîïðñòóôõöøùúûýÿÞRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuyybsaaaaaaaceeeeiiiidnoooooouuuyybRr                                 ';

    return str_replace(["-----", "----", "---", '--'], "-",
        str_replace(" ", "-",
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );
}

/**
 * @param string $string
 * @return string
 */
function str_studly_case(string $string): string
{
    $string = str_slug($string);
    return str_replace(" ", "",
        mb_convert_case(str_replace("-", " ", $string), MB_CASE_TITLE)
    );
}

/**
 * @param string $string
 * @return string
 */
function str_camel_case(string $string): string
{
    return lcfirst(str_studly_case($string));
}

/**
 * @param string $string
 * @return string
 */
function str_title(string $string): string
{
    return mb_convert_case(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS), MB_CASE_TITLE);
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_words(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    $arrWords = explode(" ", $string);
    $numWords = count($arrWords);

    if ($numWords <= $limit) {
        return $string;
    }

    $words = implode(" ", array_slice($arrWords, 0, $limit));
    return "{$words}{$pointer}";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_chars(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), " "));
    return "{$chars}{$pointer}";
}


/**
 * ###############
 * ###   URL   ###
 * ###############
 */


/**
 * @param string $url
 * @return string
 */
function url(string $path): string
{
    return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
}

/**
 * @param string $url
 * @return void
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $url = url($url);
    }

    header("Location: {$url}");
    exit;
}

/**
 * ####################
 * ###   TRIGGERS   ###
 * ####################
 */


/**
 * @return PDO
 */
function db(): PDO
{
    return \Source\Core\Connect::getInstance();
}

/**
 * @return Message
 */
function message(): Message
{
    return new Message();
}

/**
 * @return Session
 */
function session(): Session
{
    return new Session();
}