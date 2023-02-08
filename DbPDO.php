<?php

class DbPDO
{
    private static string $server = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $database = 'test';
    private static ?PDO $db = null;

    public static function connect(): ?PDO {
        if (self::$db == null){
            try {
                self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $request = self::$db->prepare("SELECT prenom, nom, pays FROM users ORDER BY id ASC");
                $all = self::$db->prepare("SELECT * FROM users ORDER BY nom ASC");
                $alpha = self::$db->prepare("SELECT * FROM users ORDER BY nom DESC");
                $flag =  self::$db->prepare("SELECT DISTINCT pays from users");

                $count =  self::$db->prepare("SELECT MIN(argent)  as argentMin from users");
                $count1 =  self::$db->prepare("SELECT MAX(argent) as argentMin from users");
                $count2 =  self::$db->prepare("SELECT MIN(argent) as argentMin from users where 1");

                $test =  self::$db->prepare("SELECT count(*)  as argentMin from users where argent < 50000");
                $test2 =  self::$db->prepare("SELECT avg(argent) as argentMin from users");
                $test6 =  self::$db->prepare("SELECT sum(argent) as argentMin from users");

                $avvv =  self::$db->prepare("SELECT * FROM users WHERE prenom LIKE 'j%'");
                $avvv2 =  self::$db->prepare("SELECT * FROM users WHERE prenom like '%s'");
                $avvv3 =  self::$db->prepare("SELECT * FROM users WHERE prenom like '%a%'");

                $check = $request->execute();
                $check = $flag->execute();
                $check = $all->execute();
                $check = $alpha->execute();

                $check = $count->execute();
                $check = $count1->execute();
                $check = $count2->execute();

                $check = $test->execute();
                $check = $test2->execute();
                $check = $test6->execute();

                $check = $avvv->execute();
                $check = $avvv2->execute();
                $check = $avvv3->execute();


                if ($check){
                    foreach ($request as $value) {
                        echo "Nom " . $value["prenom"] . "<br>";
                        echo "Prénom " . $value["nom"] . "<br>";
                        echo "Pays " . $value["pays"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($flag as $value) {
                        echo "Pays Sans doublon " . $value["pays"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($all as $value) {
                        echo "Nom " . $value["nom"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($alpha as $value) {
                        echo "Nom " . $value["nom"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($count as $value) {
                        echo "Argent minimum " . $value["argentMin"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($count1 as $value) {
                        echo "Argent maximum " . $value["argentMin"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($count2 as $value) {
                        echo "Argent " . $value["argentMin"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($test as $value) {
                        echo "Somme inférierur a 50000 : " . $value["argentMin"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($test2 as $value) {
                        echo "Moyenne d'argent " . $value["argentMin"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($test6 as $value) {
                        echo "Montant total " . $value["argentMin"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($avvv as $value) {
                        echo "utilisateurs dont la colonne prenom commence par la lettre j " . $value["prenom"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($avvv2 as $value) {
                        echo "utilisateurs dont la colonne prenom se termine par la lettre s " . $value["prenom"] . "<br>";
                        echo "<hr>";
                    }
                    foreach ($avvv3 as $value) {
                        echo "utilisateurs dont la colonne prenom contient la lettre a " . $value["prenom"] . "<br>";
                        echo "<hr>";
                    }
                }
            } catch (PDOException $e) {
                echo "Erreur de la connexion à la dn : " . $e->getMessage();
                die();
            }
        }
        return self::$db;
    }
}