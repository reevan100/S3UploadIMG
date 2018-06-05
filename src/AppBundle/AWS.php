<?php
namespace AppBundle;

class AWS
{
    public function S3UploadIMG($bucketName, $file, $imgName)
        {


                        $s3 = $this->container->get ( 'aws.s3' );
                        $keyName =  $imgName; 


                        // Add it to S3
                        try {
                            // Uploaded:
                           $result = $s3->putObject(
                                array(
                                    'Bucket'=>$bucketName,
                                    'Key' =>  $keyName,
                                    'SourceFile' => $file,
                                    'StorageClass' => 'REDUCED_REDUNDANCY',
                                    'ACL'    => 'public-read'
                                )
                            );
                        } catch (S3Exception $e) {
                            die('Error:' . $e->getMessage());
                        } catch (Exception $e) {
                            die('Error:' . $e->getMessage());
                        }
            
            return 'uploaded';
        }
}

?>