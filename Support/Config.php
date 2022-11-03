<?php

/**  DATABASE */
const CONF_DB_HOST = "localhost";
const CONF_DB_USER = "root";
const CONF_DB_PASS = "2705";
const CONF_DB_NAME = "tcc";

/** PROJECT URLs */
const CONF_URL_BASE = "http://localhost/tcc/src";
const CONF_URL_ADMIN = CONF_URL_BASE . "/admin";
const CONF_URL_ERROR = CONF_URL_BASE . "/404";

/** DATES */
const CONF_DEFAULT_TIMEZONE = "America/Sao_Paulo";
const CONF_DATE_BR = "d/m/Y";
const CONF_DATE_APP = "Y-m-d H:i:s";

/** SESSION */
const CONF_SES_PATH = __DIR__."/../assets/sessions/";

/** PASSWORD */
const CONF_PASSWD_MIN_LEN = 8;
const CONF_PASSWD_MAX_LEN = 40;
const CONF_PASSWD_ALGO = PASSWORD_DEFAULT;
const CONF_PASSWD_OPTIONS = ["cost" => 10];

/** MESSAGE */
const CONF_MESSAGE_CLASS = "trigger";
const CONF_MESSAGE_INFO = "info";
const CONF_MESSAGE_SUCCESS = "success";
const CONF_MESSAGE_WARNING = "warning";
const CONF_MESSAGE_ERROR = "error";