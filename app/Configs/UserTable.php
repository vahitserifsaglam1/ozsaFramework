<?php

  $userTable = array (

       'table' => 'user',
        'usernameTable' => 'username',
          'passwordTable' => 'password',
            'passwordType' => 'md5', #sha1 vs vs
              'realnameTable' => 'realname',
                 'emailTable' => 'email',
                    'login' => 'emailTable' ## or usernameTable

  );