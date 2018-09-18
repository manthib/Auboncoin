<?php
// Configure your Subject Prefix and Recipient here
$subjectPrefix = '[Nouvelle reservation via site web]';
$emailTo       = '<alexismoreau2@live.fr>';
$errors = array(); // array to hold validation errors
$data   = array(); // array to pass back data
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone    = stripslashes(trim($_POST['phone']));
    $date    = stripslashes(trim($_POST['date']));
    $time   = stripslashes(trim($_POST['time']));
    $person   = stripslashes(trim($_POST['person']));
    if (empty($date)) {
        $errors['date'] = 'Veuillez rentrer un numéro de téléphone.';
    }
    if (empty($date)) {
        $errors['date'] = 'Veuillez rentrer une date.';
    }
    if (empty($time)) {
        $errors['time'] = 'Veuillez rentrer une heure.';
    }
    if (empty($person)) {
        $errors['person'] = 'Veuillez rentrer le nombre de personnes.';
    }
    // if there are any errors in our errors array, return a success boolean or false
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {
        $subject = "$subjectPrefix $subject";
        $body    = '
            <strong>Téléphone: </strong>'.$phone.'<br />
            <strong>Date: </strong>'.$date.'<br />
            <strong>Heure: </strong>'.$time.'<br />
            <strong>Nombre de personnes: </strong>'.$person.'<br />
        ';
        $headers  = "MIME-Version: 1.1" . PHP_EOL;
        $headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
        $headers .= "Content-Transfer-Encoding: 8bit" . PHP_EOL;
        $headers .= "Date: " . date('r', $_SERVER['REQUEST_TIME']) . PHP_EOL;
        $headers .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>' . PHP_EOL;
        $headers .= "From: " . "Le Bon Coin Ivry " . "<contact@leboncoin-ivry.fr>" . PHP_EOL;
        $headers .= "Return-Path: $emailTo" . PHP_EOL;
        $headers .= "Reply-To: $email" . PHP_EOL;
        $headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
        $headers .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR'] . PHP_EOL;
        mail($emailTo, "=?utf-8?B?" . base64_encode($subject) . "?=", $body, $headers);
        $data['success'] = true;
        $data['message'] = 'Votre demande de réservation a bien été envoyée, nous vous recontacterons dans les plus brefs délais.';
    }
    // return all our data to an AJAX call
    echo json_encode($data);
}