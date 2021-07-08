<?php  
session_start();
$connection =mysqli_connect("localhost","root","");
$db=mysqli_select_db($connection,'pandemic');

  if(isset($_POST["export"]))
  {
   
  $query=$_SESSION['query'];
   $output='';
   $result = mysqli_query($connection, $query);



  if(mysqli_num_rows($result) > 0)
  {

    $output .= '
     <table class="table" bordered="1">  
        <tr>
            <th>Accessionid</th>
            <th>Releasedate</th>
            <th>Species</th>
            <th>Genus</th>
            <th>Family</th>
            <th>Length</th>
            <th>Sequence</th>
            <th>Completeness</th>
            <th>Protein</th>
            <th>Location</th>
            <th>USAlocation</th>
            <th>Host   </th>
            <th>Isolationsource</th>
            <th>Collection date</th>        
        </tr>
    ';
    while($row = mysqli_fetch_array($result))
    {
     $output .= '
      <tr>    
        <td>' .$row['accessionid']. '</td>
        <td>' .$row['releasedate']. '</td>
        <td>' .$row['species']. '</td>
        <td>' .$row['genus']. '</td>
        <td>' .$row['family']. '</td>
        <td>' .$row['length']. '</td>
        <td>' .$row['sequence']. '</td>
        <td>' .$row['completeness']. '</td>
        <td>' .$row['protein'] . '</td>
        <td>' .$row['location'] . '</td>
        <td>' .$row['USAlocation'] . '</td>
        <td>' .$row['host'] . '</td>
        <td>' .$row['isolationsource']. '</td> 
        <td>' .$row['collection date'] . '</td>

      </tr>
     </table>';
   }
  


    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=download.xls');
    echo $output; 
  }
}
?>