<?php

    return

      [

          'fetch' => 'object', // for mysql fetch pdo is using already PDO::FETCH_OBJ

          'default' => 'mysql',

           'Connections' =>

            [

                  'mysql' =>  [

                      'host'     => 'localhost',
                      'dbname'   => 'MVC',
                      'username' => 'root',
                      'password' => '',
                      'driver'   => 'pdo',
                      'charset'  => 'utf-8',
                      'pdoType'  => 'mysql'

                  ],

                 'sqlite' => [

                     'database' => 'dbname',

                 ],

                'mssql' => [

                    'host'     => 'hostname',
                    'dbname'   => 'dbname',
                    'username' => 'root',
                    'password' => '',
                    'driver'   => 'pdo',
                    'pdoType'  => 'dblib'

                ]

             ],

          'predis' => [

              'cluster' => false,

              'default' => [

                  'scheme'   => 'tcp',
                  'host'     => '127.0.0.1',
                  'port'     =>  6379,
                  'database' =>  0,

              ]

          ]

      ];