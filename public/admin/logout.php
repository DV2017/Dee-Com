<?php

//destroy on logout and go back to frontpage index location
session_start();
session_destroy();
header("Location: ../../public");

?>