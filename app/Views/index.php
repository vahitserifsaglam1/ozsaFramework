<?php

 $orm = new ORM('post');

  $fetch = $orm -> Getpost_id()

       ->Getpost_json()

       ->AddLimit(array(0,10))

       ->select()

       ->fetchAll();











?>