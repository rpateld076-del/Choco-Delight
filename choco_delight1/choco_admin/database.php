<?php 
$servername = "localhost"; 
$username = "root";     
$password = "";           
$conn = new mysqli($servername, $username, $password); 
if ($conn->connect_error)  
{ 
die("connection failed: " . $conn->connect_error); 
} 
$sql = "create database `dbb-1`"; 
if ($conn->query($sql) === true)  
{ 
echo "database 'db-1' created successfully.<br>"; 
}  
else  
{ 
echo "error creating database: " . $conn->error . "<br>"; 
} 
$conn->select_db("dbb-1"); 
$tablesql = "create table `mytable1` ( 
id int(6) unsigned auto_increment primary key, 
firstname varchar(50) not null, 
lastname varchar(50) not null, 
email varchar(100), 
reg_date timestamp default current_timestamp on update 
current_timestamp 
)"; 
if ($conn->query($tablesql) === true)  
{ 
echo "table 'mytable' created successfully."; 
}  
else  
{ 
echo "error creating table: " . $conn->error; 
} 
$conn->close(); 
?> 