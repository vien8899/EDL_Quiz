<?php
    include_once "db2.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_POST['post_message'])){
            $p_name = htmlspecialchars($_POST['txt_name']);
            $p_message = htmlspecialchars($_POST['txt_message']);

            //exce
            // $sql = "INSERT INTO board( name, message ) VALUES('$p_name','$p_message')";
            // $result=$dbcon->exec($sql);


            //Execute a prepared
            $sql = "INSERT INTO board( name, message ) VALUES(:name,:message)";
            $query = $dbcon->prepare($sql);
            $query->bindParam(':name',$p_name,PDO::PARAM_STR);
            $query->bindParam(':message',$p_message,PDO::PARAM_STR);
            $result = $query->execute();

            if($result){
                echo "insert success !";
            }
        }
        //load data
        $sql = "SELECT*FROM board";
        $query = $dbcon->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0){
            foreach($result as $res){
                echo $res->id."<br>";
                echo $res->name."<br>";
                echo $res->message."<br>";
            }
        }
        // $query = $dbcon->prepare($sql);
        // $query->execute();
        // $result = $query->fetchAll();
        // print_r($result);
        // print("PDO::FETCH_ASSOC: ");
        // print("Return next row as an array indexed by column name\n");
        // $result = $query->fetch(PDO::FETCH_ASSOC);
        // print_r($result);
        // echo "<br>";

        // print("PDO::FETCH_BOTH: ");
        // print("Return next row as an array indexed by both column name and nu
        // mber\n");
        // $result = $query->fetch(PDO::FETCH_BOTH);
        // print_r($result);
        // echo "<br>";

        // print("PDO::FETCH_LAZY: ");
        // print("Return next row as an anonymous object with column names as pr
        // operties\n");
        // $result = $query->fetch(PDO::FETCH_LAZY);
        // print_r($result);
        // echo "<br>";

        // print("PDO::FETCH_OBJ: ");
        // print("Return next row as an anonymous object with column names as pr
        // operties\n");
        // echo "<br>";
        // $result = $query->fetch(PDO::FETCH_OBJ);
        // print_r($result);
    ?>
    <div class="frm-post">
        <form action="" method="post">
            <input type="text" name="txt_name" required>
            <textarea name="txt_message" rows="4"></textarea>
            <button name="post_message">Post Message</button>
        </form>
    </div>
</body>
</html>