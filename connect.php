<?php

$host = 'aws-1-eu-north-1.pooler.supabase.com';
$usname = 'postgres.vixyoscfmemqajlrncyh';
$pass = "SlytherV35!OalAlAmthbuuPiKa";
$db = "postgres";
$port = 5432;

$conn = pg_connect("host=$host dbname=$db user=$usname password=$pass port=$port");

if (!$conn) {
    echo `
        <!DOCTYPE html>
        <html lang='en'>
            <head>
                <meta charset='utf-8'/>
                <link rel='stylesheet' href='style.css' type='text/css'/>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <meta hettp-equiva='X-UA-Compatible' content='IE-edge.chrome=1' />
                <link rel='website icon' href='' type='png'/>
                <link rel='stylesheet' href='css/fontello.css' type='text/css'/>
                <title>THE DEATH OF THIS SITE</title>
            </head>
            <body>
                <h1>ERROR</h1>
                <h2>This website wasn't able to connect to the databese - Tell the programmer about it. They're gonna be so happy about it...</h2>
            </body>
        </html>    
    `;
    die();
}