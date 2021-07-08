<!DOCTYPE html>
<html>
<head>
	<title>SEARCH DATA</title>
</head>
<body>
	<nav>
      <a href="welcome.html">Welcome</a>
      <a href="home.php" class="active">Home</a>
      <a href="overview.html">Overview</a>
      <a href="more.html">More</a>
    </nav>
    <div class="bigbox">
	<center>
		<form action="" method="POST">
			<label for="dp">CHOOSE A PANDEMIC: </label>
			<select id="dp" name="dp">
				<option>Pick a choice!</option>
			    <option value="Smallpox">smallpox</option>
			    <option value="Influenzavirus">influenzavirus</option>
			    <option value="Coronavirus">coronavirus</option>
			    <option value="h2n2">h2n2</option>
			    <option value="h3n2">h3n2</option>
			    <option value="hiv">hiv</option>
			    <option value="ALL">ALL</option>
			</select>

			<input type="text" name="id" placeholder="Enter the data"/><br/>
			<br/>
			<br/>
			<label for="rd">SORT BY:</label>
			<select id="rd" name="rd">
				<option>Pick a choice!</option>
			    <option value="Accessionid">accessionid</option>
			    <option value="Releasedate">releasedate</option>
			    <option value="Species">species</option>
			    <option value="Genus">genus</option>
			    <option value="Family">family</option>
			    <option value="Length">length</option>			    
			    <option value="Sequence">sequence</option>
			    <option value="Completeness">completeness</option>
			    <option value="Protein">protein</option>			    
			    <option value="Host">host</option>
			</select>
			<input type="checkbox" id="order" name="order" value='order'>
 			<label for="order">Check the box for sorting in descending order</label><br>
			<br/>
			<br/>
			<input type="submit" name="search" id ='search-btn' value="Search Data">
		</form>
	</center>
    </div>
<?php
session_start();

$connection =mysqli_connect("localhost","root","");
$db=mysqli_select_db($connection,'pandemic');
global $query;
if(isset($_POST['search']))
{
	global $query;
	$order='abd';
	if(isset($_POST['order']))
	{
		$order=$_POST['order'];
	}

	$dp = $_POST['dp'];
	$rd = $_POST['rd'];
	$id = $_POST['id'];
	if($dp=="ALL")
	{
		if($rd != 'Pick a choice!' and $id=='' and $order=='order')
		{
			$query = "SELECT * FROM influenzavirus ORDER BY $rd DESC";
		} 
		else if($rd != 'Pick a choice!' and $id=='' and $order!='order')
		{
			$query = "SELECT * FROM influenzavirus ORDER BY $rd DESC";
		}
		else if ($rd == 'Pick a choice!' and $id=='')
		{
			$query = "SELECT * FROM influenzavirus";
		}
		else
		{
			echo "ALL failed";
		}
		
	}
	else
	{
		if($id=='' and $dp != 'Pick a choice!' and $dp!="ALL" and $rd != 'Pick a choice!' and $order =="order")
		{
			$query = "SELECT * FROM $dp ORDER BY $rd DESC";
		}
		else if($id=='' and $dp != 'Pick a choice!' and $dp!="ALL" and $rd != 'Pick a choice!' and $order !="order")
		{
			$query = "SELECT * FROM $dp ORDER BY $rd";
		}
		else if(($id=='' and $dp=="Pick a choice!" and $rd != 'Pick a choice!' and ($order !="order" or $order =="order") ) or ($id=='' and $dp=="Pick a choice!" and $rd == 'Pick a choice!' and ($order !="order" or $order =="order")))
		{
			$query = "SELECT * FROM influenzavirus";
		}
		else
		{
			$query = "SELECT * FROM $dp where accessionid LIKE '$id'  OR species LIKE '$id%' OR genus LIKE '$id%' OR family LIKE '$id%' OR sequence LIKE '$id%' OR protein LIKE '$id%'  OR location LIKE '$id%' ";
		}
		
	}


	  	
	$query_run = mysqli_query($connection,$query);
	echo "ENTERED VALUE : ".$id;
	echo "<br>";
	echo "<br>";
	if($dp!='Pick a choice!')
	{
		echo "SELECTED DATA FROM ".$dp." DATABASE";
	}
	echo "<br>";
	echo "<br>";
	if($rd!='Pick a choice!')
	{
		echo "SORTED ACCORDING TO ".$rd;	
	}


	echo "<div class='btn'>";
    	echo "<form action='export.php' method='POST'>";
			echo "<input type='submit' id='Exportbtn' name='export' class='btn btn-success' value='Export Data' />";
		echo "</form>";
	echo "</div>";

	echo "<table>";
	    echo "<tr>";
        	echo "<th>Accessionid</th>";
        	echo "<th>Releasedate</th>";
    		echo "<th>Species</th>";
    		echo "<th>Genus</th>";
        	echo "<th>Family</th>";
        	echo "<th>Length</th>";
    		echo "<th>Sequence</th>";
    		echo "<th>Completeness</th>";
        	echo "<th>Protein</th>";
        	echo "<th>Location</th>";
    		echo "<th>USAlocation</th>";
    		echo "<th>Host   </th>";
        	echo "<th>Isolationsource</th>";
        	echo "<th>Collection date</th>";    		
    	echo "</tr>";

	while($row=mysqli_fetch_array($query_run))
	{
	

		echo "<tr>";
			echo "<td>" .$row['accessionid']. "</td>";
			echo "<td>" .$row['releasedate']. "</td>";
			echo "<td>" .$row['species']. "</td>";
			echo "<td>" .$row['genus']. "</td>";
			echo "<td>" .$row['family']. "</td>";
			echo "<td>" .$row['length']. "</td>";
			echo "<td>" .$row['sequence']. "</td>";
			echo "<td>" .$row['completeness']. "</td>";
			echo "<td>" .$row['protein'] . "</td>";
			echo "<td>" .$row['location'] . "</td>";
			echo "<td>" .$row['USAlocation'] . "</td>";
			echo "<td>" .$row['host'] . "</td>";
			echo "<td>" .$row['isolationsource']. "</td>"; 
			echo "<td>" .$row['collection date'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
$_SESSION['query']=$query;

}

mysqli_close($connection);



?>	









<style>
#dp:focus option:first-of-type {
    display: none;
}
#rd:focus option:first-of-type {
    display: none;
}
table {
  width:100%;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  text-align: left;
}
tr:nth-child(even) {
  background-color: #eee;
}
tr:nth-child(odd) {
 background-color: #fff;
}
th {
  background-color: black;
  color: white;
}

nav {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1;
    width: 100%;
    height: 60px;
    background-color: #333;
    margin: auto;
}

nav a {
    color: white;
    display: block;
    float: left;
    padding: 19px;
    text-align: center;
}

nav a:hover {
    color: black;
    background-color: #ddd;
}

nav a.active {
    color: black;
    background-color: #779800;
}


.bigbox
{
	border: 3px solid black;
    float: middle;
    margin: 10px;
    margin-left: 50%;
	padding-top: 10px;
    margin-top:  460px;
    width: 150px;
    background-image: linear-gradient(#76e670 , #70e6d4 );
    border-radius: 50px;

}

#search-btn
{
margin: 5px;
padding: 5px;
border:none;
text-decoration:none;
font-family:"Lato";
font-weight: 300;
font-size: 150%;
color: white;
background: rgb(66, 188, 245);
transition:all 500ms ease;
border-radius: 10px;
margin-left: 10px;
}
#search-btn:hover
{
  color:white;
  background:rgb(66, 188, 245);
  padding: 8px;	
  box-shadow: 0 0 2px 1px rgba(17, 17, 207, 3);
}

#Exportbtn
{
color: white;
border-radius: 15px;	
font-family:"Lato";
font-weight: 300;
font-size: 125%;
margin: 5px;
padding: 5px;
transition:all 500ms ease;
background-color: #29e32c;
border:2px solid white;
}

#Exportbtn:hover
{
 
  padding: 8px;
}

body
{
background-image: linear-gradient(to right, #fa709a 0%, #fee140 100%);
font-family: 'Open Sans', sans-serif;
}
</style>

</body>
</html>