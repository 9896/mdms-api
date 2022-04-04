<?php

if(in_array("mysql", PDO::getAvailableDrivers())){
    echo "You have pdo mysql installed";
}else{
    echo "Pdo mysql not there";
}