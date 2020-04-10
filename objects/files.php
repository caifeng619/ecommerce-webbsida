<?php

class Files{

    private $upload_folder;

    public function __construct($upload_folder) {

        $this->upload_folder=$upload_folder;

    }

    public function uploadFile($file){

        $returnObj=new stdClass();

        $file_original_name=$file['name'];
        $file_type=$file['type'];
        $file_tmp_name=$file['tmp_name'];
        $file_error=$file['error'];
        $file_size=$file['size'];

        $slized_file=explode(".", $file_original_name);
        $uniq_file_name=md5($slized_file[0].uniqid('', true).time()) . "." . $slized_file[1];

        $target_file=$this->upload_folder . $uniq_file_name;
        $imageFileType = strtolower(pathinfo($file_original_name,PATHINFO_EXTENSION));

        $allowed_img=['jpg', 'png', 'jpeg', 'gif'];
        if(in_array($imageFileType, $allowed_img)){

            if($file_error == 0){

                if($file_size <500000){

                    $isUploaded= move_uploaded_file($file_tmp_name, $target_file);

                    if($isUploaded){

                        return $uniq_file_name;
                        
                    }else{
                        return false;
                        $returnObj->message = "Error";
                    }

                }else{
                    return false;
                    $returnObj->message="Filen is too big!";
                }
            }else{
                return false;
                $returnObj->message="There was an error when uploading your file";
            }
        }else{
            return false;
            $returnObj->message="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        return json_encode($returnObj);
    }
}

?>

