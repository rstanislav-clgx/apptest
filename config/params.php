<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'xRapidConfigs'=>[
        'xRapidApiKey'=> '3446d0341fmsh02187e321ed96b8p144faejsn5804b29fe2f0',
        'xRapidApiHost'=>'yh-finance.p.rapidapi.com',
        'xRapidUri'=>'/stock/v3/get-historical-data',
     ],
    'mailerTransport'=>[
        'dsn' => 'smtp://stas.revko@gmail.com:zN92qIREYwFmkgr5@smtp-relay.sendinblue.com:587',
    ],
    'mailerUseFileTransport'=>true, //if it's true, mailer creates files in /runtime/mail instead of real mailing
    'companiesDataJsonFile'=>dirname(__DIR__)."/data/companies.json",
];
