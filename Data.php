<?php 
  if(!session_id()) {
    session_start();
  } 

// // Create connection
$conn;

//The open and close connection bits weren't working as intended,
//I was trying to pass back the open connection for use and allow the dev
//To close it whenever they were done but the return was always null
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
?>