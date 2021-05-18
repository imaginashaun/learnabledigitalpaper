<?php

namespace App\Http\Controllers;

use App\LearningPathItem;
use App\StudentLearningPath;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use mikehaertl\pdftk\Pdf;
use Twilio\Rest\Client;

use Dompdf\Dompdf;
use Mpdf\Mpdf;

use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;

class WhatsAppController extends Controller
{
    //

    public function receive(Request $request){

       // $itemchosen = 0;

        $number = $this->getNumberOnly($request->post('From'));

        $user = User::where(['email'=>$number."@itslearnable.co.za"])->first();




        $itemchosen = $request->post('Body');

        if(is_numeric($itemchosen)){

            $sid = 'AC860ff84bed67061e0fafeae3bb0be080';
            $token = '154aa1fdeb710b2c7e9e2439bbc92c60';
            $client = new Client($sid, $token);

            $client->messages
                ->create("whatsapp:+".$number, // to
                    array(
                        "from" => "whatsapp:+27600702321",
                        "body"=>"Packaging content. One moment..."
                    )
                );

            if($user->last_response_type == 1){

                $jsonresponse = json_decode($user->last_response, TRUE);

                $pos = 1;

                foreach($jsonresponse as $jres){

                    if($itemchosen == $pos){

                        $response_string = $jres['learning_path_title'].":\n";

                        $all_learningpaths = LearningPathItem::select(['learning_path_items.*'])->where('learning_path_id', '=', $jres['id'])->get();


                        foreach ($all_learningpaths as $lpi_s){

                            if($lpi_s->lesson_type_id == 2){

                                $this->sendMultipleChoice($number,$lpi_s);
                            }
                            if($lpi_s->lesson_type_id == 1){

                                $this->sendLiterature($number,$lpi_s);
                            }

                            if($lpi_s->lesson_type_id == 4){

                                $this->sendVideo($number,$lpi_s);
                            }

                        }


                        return response( $all_learningpaths, Response::HTTP_OK);

                    }

                    $pos++;
                }

                return response( $jsonresponse, Response::HTTP_OK);
            }

        }else {
            $learningpathitems = StudentLearningPath::select(['learning_paths.*'])->join('learning_paths', function ($join) {
                $join->on('learning_paths.id', '=', 'student_learning_paths.student_learning_path_lesson_id');
            })->where('student_learning_paths.student_learning_path_student_id', '=', $user->id)->get();

            $pos = 0;

            $response_string = "Hi, " . $user->name . "! \nHere are your recent classes:\n";
            foreach ($learningpathitems as $lpi) {
                $pos++;

                $response_string .= $pos . ") *" . $lpi->learning_path_title . ".*\n";

            }

            $response_string .= "---------------\nRespond with the class number to view learning paths.";
//student_learning_path_student_id

            $user->last_response = $learningpathitems->jsonSerialize();
            $user->last_response_type = 1;

            $user->save();

            $this->sendResponseMessage($number, $response_string);
        }

      //  $message = "Hi, ".$user->name."!";

      //  $this->sendResponseMessage($number, $message);



        return response( 1, Response::HTTP_OK);
    }


    public function getNumberOnly($number){

        $replace = "whatsapp:+";

        return str_replace($replace, "", $number);

    }


    public function sendResponseMessage($number, $response){
        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC860ff84bed67061e0fafeae3bb0be080';
        $token = '154aa1fdeb710b2c7e9e2439bbc92c60';
        $client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
        $message = $client->messages
            ->create("whatsapp:+".$number, // to
                array(
                    "from" => "whatsapp:+27600702321",
                    "body" => $response
                )
            );


       return $this->getNumberOnly($message->from);
    }

    public function sendMultipleChoice($number,$multiplechoice){

        $sid = 'AC860ff84bed67061e0fafeae3bb0be080';
        $token = '154aa1fdeb710b2c7e9e2439bbc92c60';
        $client = new Client($sid, $token);

        $multiplechoice_obj = json_decode($multiplechoice->learning_path_item_object, TRUE);


        if($multiplechoice_obj['type'] == 2) {
            print_r($multiplechoice_obj['questions']);

            $html = "<div style='width: 100%'><center><h2>" . $multiplechoice->learning_path_item_title . "</h2></center></div>" . '<form>';
            $p = 1;
           foreach ($multiplechoice_obj['questions'] as $qs) {

                $html .= '<b>' . $p . ") " . $qs['body'] . '</b>
<input type="text" style="width: 100%;" name="' . $p . '" id="' . $p . '" value="" />
            <hr>';
                $p++;
            }


            /*
                       $this->runqa_new($multiplechoice_obj);
                       $filename = 'multiple/questions.pdf';
                       $location = getenv("APP_URL")."/".$filename;

                       $message = $client->messages
                           ->create("whatsapp:+".$number, // to
                               array(
                                   "from" => "whatsapp:+27600702321",
                                   "mediaUrl" => [$location],
                                   "body"=>"Title"
                               )
                           );

                      // echo $location;
                    //   die();
           */
            $html .= '</form>';
            // return response( $multiplechoice_obj, Response::HTTP_OK);

        }else{

            $html = "<div style='width: 100%'><center><h2>" . $multiplechoice->learning_path_item_title . "</h2></center></div>" . '<form>';
            $p = 1;
            foreach ($multiplechoice_obj['questions'] as $qs) {

                $html .= '<b>' . $p . ") " . $qs['title'] . '</b><br>';
                $select_pos = 0;
                foreach ($qs['options'] as $opt) {
                    if($opt != null) {
                        $html .= '<input type="radio" name="' . $p . '" value="' . $select_pos . '" /> '.$opt.' <br>
                    ';
                    }
                    $select_pos++;
                }
                $html .= '<hr>';
                $p++;
            }

        }
        $html .= '</form>';

        $mpdf=new mPDF();

        $mpdf->default_lineheight_correction = 1.2;

        // LOAD a stylesheet
        //  $stylesheet = file_get_contents('mpdfstyletables.css');
        //$mpdf->WriteHTML($stylesheet,1);    // The parameter 1 tells that this is css/style only and no body/html/text
        //  $mpdf->SetColumns(2,'J');
        $mpdf->useActiveForms = true;
        $mpdf->WriteHTML($html);

        $filename = time().'.pdf';
        $mpdf->Output($filename,\Mpdf\Output\Destination::FILE);//

        $location = getenv("APP_URL")."/".$filename;

        $message = $client->messages
            ->create("whatsapp:+".$number, // to
                array(
                    "from" => "whatsapp:+27600702321",
                    "mediaUrl" => [$location],
                    "body"=>"Title"
                )
            );

     //   echo $message->sid;
    }
    public function sendVideo($number,$literature){

        $sid = 'AC860ff84bed67061e0fafeae3bb0be080';
        $token = '154aa1fdeb710b2c7e9e2439bbc92c60';
        $client = new Client($sid, $token);



        $client->messages
            ->create("whatsapp:+".$number, // to
                array(
                    "from" => "whatsapp:+27600702321",
                    "body"=>"Preparing your video."
                )
            );

// Use the client to do fun stuff like send text messages!

        $filename = 'eutrophication.mp4';
        $location = getenv("APP_URL")."/multiple/".$filename;

        $message = $client->messages
            ->create("whatsapp:+".$number, // to
                array(
                    "from" => "whatsapp:+27600702321",
                    "mediaUrl" => [$location],
                    "body"=>"Video"
                )
            );
        echo $message->sid;
    }

    public function sendLiterature($number,$literature){

        $sid = 'AC860ff84bed67061e0fafeae3bb0be080';
        $token = '154aa1fdeb710b2c7e9e2439bbc92c60';
        $client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!

        $literature_obj = json_decode($literature->learning_path_item_object, TRUE);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml("<center><h2>".$literature->learning_path_item_title."</h2></center>".$literature_obj['body']);

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
        $dompdf->render();

        $output = $dompdf->output();
        $filename = time().'.pdf';
        file_put_contents($filename, $output);
        $location = getenv("APP_URL")."/".$filename;

        $message = $client->messages
            ->create("whatsapp:+".$number, // to
                array(
                    "from" => "whatsapp:+27600702321",
                    "mediaUrl" => [$location],
                    "body"=>"Title"
                )
            );

        echo $message->sid;

    }

    public function runqa_new($object){

        $html = '';
        $ob = $object;
        $pdf = new Pdf([
            'multiple/Multiple_1.pdf',         // C is alias for file3.pdf
        ]);

        foreach ($ob['questions'] as $q){
            $result = $pdf->cat(1);

            $html .= '<div style="page-break-after: always;"><h2 style="font-size: 30pt;">'.strip_tags($q['body']).'</h2></div>
';
        }


        // pages 2,3 and 7 from C
        $result->saveAs('multiple/done.pdf');
        if ($result === false) {
            $error = $pdf->getError();
            echo $error;
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $customPaper = array(0,0,300,1320);
// (Optional) Setup the paper size and orientation
        $dompdf->setPaper($customPaper, 'landscape');

// Render the HTML as PDF
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('multiple/cropped.pdf', $output);

        // Stamp with another PDF (first page repeated)


        $pdf = new Pdf('multiple/done.pdf');
        $result = $pdf->multiStamp('multiple/cropped.pdf')
            ->saveAs('multiple/questions.pdf');
        if ($result === false) {
            $error = $pdf->getError();
        }

    }

    public function testmultiple(){



            $number = "27678971105";

            $sid = 'AC860ff84bed67061e0fafeae3bb0be080';
            $token = '154aa1fdeb710b2c7e9e2439bbc92c60';
            $client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!

            $filename = 'eutrophication.mp4';
            $location = getenv("APP_URL")."/multiple/".$filename;

            $message = $client->messages
                ->create("whatsapp:+".$number, // to
                    array(
                        "from" => "whatsapp:+27600702321",
                        "mediaUrl" => [$location],
                        "body"=>"Video"
                    )
                );
            echo $location."<br>";
            echo $message->sid;


        die();


        $object = '{
    "type": 2,
    "questions": [
        {
            "body": "<p>Give them a question</p>",
            "wordLimit": 0
        },
        {
            "body": "<p>Give them another question</p>",
            "wordLimit": 0
        }
    ]
}';


        $html = '';

        $ob = json_decode($object, true);
        $pdf = new Pdf([
            'multiple/Multiple_1.pdf',         // C is alias for file3.pdf
        ]);

        foreach ($ob['questions'] as $q){
            $result = $pdf->cat(1);

            $html .= '<div style="page-break-after: always;"><h2 style="font-size: 30pt;">'.strip_tags($q['body']).'</h2></div>
';
        }


           // pages 2,3 and 7 from C
        $result->saveAs('multiple/done.pdf');
        if ($result === false) {
            $error = $pdf->getError();
            echo $error;
                }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $customPaper = array(0,0,300,1320);
// (Optional) Setup the paper size and orientation
        $dompdf->setPaper($customPaper, 'landscape');

// Render the HTML as PDF
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('multiple/cropped.pdf', $output);

        // Stamp with another PDF (first page repeated)


        $pdf = new Pdf('multiple/done.pdf');
        $result = $pdf->multiStamp('multiple/cropped.pdf')
            ->saveAs('multiple/questions.pdf');
        if ($result === false) {
            $error = $pdf->getError();
        }

    }

    public function test(){

        $itemchosen = 1;

        $testphone = "whatsapp:+27678971105";

        $number = $this->getNumberOnly($testphone);

        $user = User::where(['email'=>$number."@itslearnable.co.za"])->first();

        $response_string = "";

        if(is_int($itemchosen)){

            if($user->last_response_type == 1){

               $jsonresponse = json_decode($user->last_response, TRUE);

               $pos = 1;
               foreach($jsonresponse as $jres){

                   if($itemchosen == $pos){

                       $response_string = $jres['learning_path_title'].":\n";

                       $all_learningpaths = LearningPathItem::select(['learning_path_items.*'])->where('learning_path_id', '=', $jres['id'])->get();


                       foreach ($all_learningpaths as $lpi_s){

                           if($lpi_s->lesson_type_id == 2){

                               $this->sendMultipleChoice($number,$lpi_s);
                           }
                           if($lpi_s->lesson_type_id == 1){

                               $this->sendLiterature($number,$lpi_s);
                           }

                           if($lpi_s->lesson_type_id == 4){

                               $this->sendVideo($number,$lpi_s);
                           }

                       }


                       return response( $all_learningpaths, Response::HTTP_OK);

                   }

                   $pos++;
               }

                return response( $jsonresponse, Response::HTTP_OK);
            }

        }else {
            $learningpathitems = StudentLearningPath::select(['learning_paths.*'])->join('learning_paths', function ($join) {
                $join->on('learning_paths.id', '=', 'student_learning_paths.student_learning_path_lesson_id');
            })->where('student_learning_paths.student_learning_path_student_id', '=', $user->id)->get();


            $pos = 0;

            $response_string = "Hi, " . $user->name . "! \nHere are your recent classes:\n";
            foreach ($learningpathitems as $lpi) {
                $pos++;

                $response_string .= $pos . ") *" . $lpi->learning_path_title . ".*\n";

            }

            $response_string .= "---------------\nRespond with the class number to view learning paths.";
//student_learning_path_student_id


            $user->last_response = $learningpathitems->jsonSerialize();
            $user->last_response_type = 1;

            $user->save();

            $this->sendResponseMessage($number, $response_string);
        }

      //  return response( $learningpathitems->jsonSerialize(), Response::HTTP_OK);
        return response( $response_string, Response::HTTP_OK);
    }
}
