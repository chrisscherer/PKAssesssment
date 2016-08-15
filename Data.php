<?php 
  if(!session_id()) {
    session_start();
  } 

// // Create connection
$conn;

function OpenConnection(){
  $servername = "localhost";
  $username = "root";
  $password = "Scherer22";
  $database = "PK_Lottery";

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 
}

function Query($query){
    $servername = "localhost";
  $username = "root";
  $password = "Scherer22";
  $database = "PK_Lottery";

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 

  $conn->query($query);

  $conn->close();
}

function ResultQuery($query){
  $servername = "localhost";
  $username = "root";
  $password = "Scherer22";
  $database = "PK_Lottery";

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 

  return $conn->query($query);
}

function CloseConnection(){
  $conn->close();
}

function Test(){
  echo "TEST@@@@@@@@@@@@@@@@!!!!!!!!!!";
}
// ?>