<?php
/**
 * Created by IntelliJ IDEA.
 * User: fahziar
 * Date: 23/02/2016
 * Time: 12.51
 */
require 'session.php';

SessionManager::sessionStart();
SessionManager::logout();
header("Location: /");