<?php 
require __DIR__.'../../vendor/autoload.php';
require  __DIR__."../../phpqrcode/qrlib.php";
session_start();
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;
use Kreait\Firebase\Auth\CreateUserWithEmailAndPassword;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Auth;

$factory = (new Factory)
    ->withServiceAccount( __DIR__ . '/striped-harbor-351908-firebase-adminsdk-n9biq-49fe424891.json')
    ->withDatabaseUri('https://striped-harbor-351908-default-rtdb.firebaseio.com');

$auth = $factory->createAuth();
$realtimeDatabase = $factory->createDatabase();
$storage = $factory->createStorage();
$bucket = $storage->getBucket();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES['profile_img'])) {

        $image = $_FILES['profile_img'];

        $storage = new StorageClient([
            'keyFilePath' =>  __DIR__ . '/striped-harbor-351908-firebase-adminsdk-n9biq-49fe424891.json',
        ]);
    
        $destination = 'department_profile_image/' . uniqid() . '_' . $image['name'];
    
        $bucketName = 'striped-harbor-351908.appspot.com';
        $bucket = $storage->bucket($bucketName);
        $object = $bucket->upload(
            fopen( $image['tmp_name'], 'r'),
            [
                'name' => $destination,
            ]
        );


        $realtimeDatabase->getReference('users/' . $_SESSION['id'])->update(
            [
                'profile_img' => $bucket->object($destination)->signedUrl(new \DateTime('+10 years')),
             
            ]
          
        );

         $_SESSION['profile_img'] = $_SESSION['profile_img'];

    }else {
        $realtimeDatabase->getReference('users/' . $_SESSION['id'])->update(
            [
                'name'    => $_POST['name'],
                'email'    => $_POST['email'],
                'username'    => $_POST['username'],
                'password'    => $_POST['password'],
             
            ]
          
        );

        $_SESSION['name'] = $_POST['name'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['status'] = $_POST['status'];
        $_SESSION['department'] = $_SESSION['department'];
        $_SESSION['customer_dept'] = $_SESSION['customer_dept'];
        $_SESSION['bir'] = $_SESSION['bir'];
        $_SESSION['dti'] = $_SESSION['dti'];
        $_SESSION['mayors_permit'] = $_SESSION['mayors_permit'];
        $_SESSION['sec'] = $_SESSION['sec'];
    }

}


?>