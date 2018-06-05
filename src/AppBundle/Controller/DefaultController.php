<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use calcinai\Imageick;

class DefaultController extends Controller 
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
            $bucketName = 'reevan-bucket';

            if ($request->isMethod('POST')){
                        // You may need to change the region. It will say in the URL when the bucket is open

//                        $a =new \Imagick();
                    $s3 = $this->container->get ( 'aws.s3' );
                  
                    // For this, I would generate a unqiue random string for the key name. But you can do whatever.
                    $keyName =  basename($_FILES["image"]['name']); 


                    // Add it to S3
                    try {
                        // Uploaded:
                        $file = $_FILES["image"]['tmp_name'];
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
            }
        
        return $this->render('file.html.twig');
    }

    /**
     * @Route("/display", name="display")
     */
    public function displayAction(Request $request)
    {
        $bucketName = 'reevan-bucket';
        $items = array();

        $s3 = $this->container->get ( 'aws.s3' );

        $iterator = $s3->getIterator('ListObjects', array(
            'Bucket' => $bucketName
        ));

        foreach ($iterator as $object) {
            $items[] = $object['Key'];
        }


        return $this->render('display.html.twig', array('images' => $items));
    }

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
