AWS_S3
======

A Symfony project created on May 30, 2018, 12:00 pm.


1. In the config.yml add the following.
	
	aws:
	   version: latest
	   region: us-east-1
	   credentials:
	       key: "Your KEY "
	       secret: "Your SECRET Key"
	   DynamoDb:
	       region: ap-southeast-1
	   S3:
	       version: '2006-03-01'
	       region: us-east-1

2. Add the following in AppKernel.php in bundles

	new \Aws\Symfony\AwsBundle 


3. Now You can use the upload functionality in your project directly
	
	$s = techjini\aws_s3::S3UploadIMG($bucketName, $file, $imgName);

	$bucketName : the name of the bucket
	$file : the file 
	$imgName: the file name