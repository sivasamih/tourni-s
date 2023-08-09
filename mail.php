<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // access
        // $secretKey = '6LeaCoAUAAAAAL7_KZkqgmtPTVXAVjAh42hc8kgR';
        // $captcha = $_POST['g-recaptcha-response'];

        // if(!$captcha){
        //   echo '<p class="alert alert-warning">Please check the the captcha form.</p>';
        //   exit;
        // }

        # FIX: Replace this email with recipient email
        $mail_to = "sales@tourni-s.com";  //sales@tourni-s.com
        
        # Sender Data
        $subjectMaster ="Enquiry From Tourni-S Website";
        $subject=str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["subject"])));
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        // $phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);

        // print "name :".$name."<br/>";
        // print "email :".$email."<br/>";
        // print "subject :".$subject."<br/>";
        // print "message :".$message."<br/>";
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL)  OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo '<p class="alert alert-warning">Please complete the form and try again.</p>';
            exit;
        }

        /*
        $ip = $_SERVER['REMOTE_ADDR'];
        // $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        // $responseKeys = json_decode($response,true);

        # Mail Content
        $content = "Name: $name\n";
        $content .= "Email: $email\n\n";
        // $content .= "Phone: $phone\n";
        $content .= "Message:\n$message\n";

        # email headers.
        $headers = "From: $name <$email>";

        # Send the email.
        $success = mail($mail_to, $subject, $content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo '<p class="alert alert-success">Thank You! Your message has been sent.</p>';
            $url='https://tourni-s.com/';
            echo '<script>window.location = "'.$url.'";</script>';
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo '<p class="alert alert-warning">Oops! Something went wrong, we couldnt send your message.</p>';

        }
        */

        

        $spamList=['adrii.arag@hotmail.com','jessica_guevara6871@yahoo.com' ,'RobertDof'];

        if (stripos(json_encode($spamList),$email) !== false || stripos(json_encode($spamList),$name) !== false  || $subjectMaster!==$subject || strlen($message)>100) {
            // echo "found mystring";
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo '<p class="alert alert-warning">Oops! Spam activity found, we couldnt send your message.</p>';

        }else{

            $data = array(
                "email" => $email,
                "name" => $name,
                "subject" => $subject ,
                "message" => "Message:\n$message\n",
            );
    
            $reqData = array(
                'WebsiteData' => array(
                    "SourceID" => 5,
                    "TypeID" => 1,
                    "isChecked" => false,
                    "JsonData" =>  json_encode($data)
                )
            );
    
        $curl = curl_init();
        $APIURL1 = "http://203.122.12.35:8082/api/WebSite/Add_Update_WebsiteData";
        curl_setopt_array($curl, [
            CURLOPT_URL => $APIURL1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($reqData),
            CURLOPT_HTTPHEADER => [
                'Content-Type:application/json'
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            //echo "true";
            http_response_code(200);
            echo '<p class="alert alert-success">Thank You! Your message has been sent.</p>';
            $url = 'https://tourni-s.com/';
            echo '<script>window.location = "' . $url . '";</script>';
        } else {
            //echo "true";
            http_response_code(200);
            echo '<p class="alert alert-success">Thank You! Your message has been sent.</p>';
            $url = 'https://tourni-s.com/';
            echo '<script>window.location = "' . $url . '";</script>';
        }

        }

       


    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo '<p class="alert alert-warning">There was a problem with your submission, please try again.</p>';
    }
