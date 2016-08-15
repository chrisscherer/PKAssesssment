<?php 
  if(!session_id()) {
    session_start();
  } 
?>

<?php
  include 'Data.php';

  $ticketNumber = $_GET['TicketNumber'];
  $user_id = $_SESSION['user_id'];

  Query("INSERT INTO `Tickets` (`Ticket_Number`) VALUES ('$ticketNumber')");
  Query("INSERT INTO `Users_Tickets` (`User_Id`, `Ticket_Number`) VALUES ('$user_id', '$ticketNumber')");

  header('Location: http://www.sheerforcestudios.com/PK/Index.php');
?>