<?php
// get connexion 
$conn  = new PDO("mysql:host=localhost;dbname=my_ajax","root","");
// requete
$sql = "SELECT * FROM lieu ORDER BY id DESC;";
$req = $conn->query($sql);
 while($tab = $req->fetch()){
?>
        <tr>
            <td><?php echo($tab['id']); ?></td>
            <td><?php echo($tab['nom']); ?></td>
            <td><?php echo($tab['climat']); ?></td>
            <td>
                <a href="#"><span class="fa fa-edit"></span></a>
                <a href="#"><span class="fa fa-trash-o"></span></a>
            </td>
        </tr>
                       
 <?php } ?>