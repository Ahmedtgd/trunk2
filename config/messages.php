<?php
return [
    /*
     * Message types
     * 1)success
     * 2)error
     * 3)warning  => this has deleted ,in process or will be considered in future
     * 4)already  => this has already been done
     * 5)system   => all system generated messages related to key
     * */
    //Suggestion
    //here you can also style for css
    //system messages

    'key'=>[
      'name'=>'message'
    ],
    'success'=>[
		'humancapRegistered'=>[
            'title'=>'Success!',
            'message'=>' Successfully registered, please verify your email'
        ],
        'merchantRegistered'=>[
            'title'=>'Success!',
            'message'=>' Successfully registered, please verify your email'
        ],
        'stationRegistered'=>[
            'title'=>'Success!',
            'message'=>' Successfully registered, please verify your email'
        ],	
		'buyerRegistered'=>[
            'title'=>'Success!',
            'message'=>' Successfully registered, please verify your email'
        ],	
		
    ],

    'error'=>[
		'humancapError'=>[
            'title'=>'Error:',
            'message'=>' There was an error while registration, please, try again later'
        ],
		'merchantError'=>[
            'title'=>'Error:',
            'message'=>' There was an error while registration, please, try again later'
        ],
        'popupStationError'=>[
            'title'=>'Error:',
            'message'=>' There was an error, please make sure the station exists'
        ],
        'popupMerchantError'=>[
            'title'=>'Error:',
            'message'=>' There was an error, please make sure the merchant exists'
        ],
        'popupBuyerError'=>[
            'title'=>'Error:',
            'message'=>' There was an error, please make sure the buyer exists'
        ],
        'sessionError'=>[
            'title'=>'Error:',
            'message'=>' Please, log in'
        ]	
		
    ],

    'warning'=>[
        'deleted'=>[
            'activateAccount'=>[
                'message'=> 'This account has been deleted.'
            ],
        ],
        'in-process'=>[
            'activateAccount'=>[
                'message'=> ''
            ],
        ],
        'in-future'=>[  ],
        'already'=>[
            'activateAccount'=>[
                'message'=> '',
            ],
            'accountExist'=>[
                'message'=> 'This account is already exist.'
            ],
            'JoiningContestBeforeLogInRequired'=>[
                'message'=> 'You already have joined this contest. Please join another.'
            ],
        ],
        'not-existence'=>[
            'activateAccount'=>[
                'title' => '<strong>Account activation !</strong><br>',
                'message'=> '<strong>Not-existence </strong> This account does not exist.'
            ],
            'UserNotExist'=>[
                'title'=>'User Not Exist',
                'message'=>'User with this email doest not exist.Please sign up and try again.'
            ],
        ],
        'invalid'=>[
            'activateAccount'=>[
                'title' => '<strong>Account activation !</strong><br>',
                'message'=> '<strong>In valid state </strong> Please contact our our team.'
            ],
            'email'=>[
                'title' => '<strong>Account activation!</strong><br>',
                'message'=> '<strong>In valid email </strong> Please contact our our team.'
            ],
        ],
        'expired'=>[
            'activateAccount'=>[
                'title' => '<strong>Account Information !</strong><br>',
                'message'=> '<strong>Expired </strong> Please contact our our team.'
            ],
        ],
        'limit'=>[
            'reached'=>[
                'message'=> 'Sorry! The contestant limit has been reached for this contest. Please join another.'
            ],
        ],
        'deny'=>[
            'AdminDeleteQuestion'=>[
                'title' => '<strong>Denied Deleting Question:</strong><br>',
                'message'=> '<strong>Warning. </strong> The question(s) may be associate with contest'
            ],
            'AdminDeletePrize'=>[
                'title' => '<strong>Denied Deleting Prize:</strong><br>',
                'message'=> '<strong>Warning. </strong> The prize(s) may be associate with contest'
            ],
            'AdminDeleteUsers'=>[
                'title' => '<strong>Denied Deleting User:</strong><br>',
                'message'=> '<strong>Warning. </strong> The user(s) may be associate with contest'
            ],
            'SuperUserCantDelete'=>[
                'title' => '<strong>Denied Deleting Super User:</strong><br>',
                'message'=> '<strong>Warning. </strong> The Super user can not be deleted'
            ],
            'AdminDeleteContest'=>[
                'title' => '<strong>Denied Deleting Contest:</strong><br>',
                'message'=> '<strong>Warning. </strong> The contest(s) may be in running form.'
            ],
        ]

    ],

    'system'=>[],

    'info'=>[
        'require'=>[
            'UserRequirePaymentInfo'=>[
                'message'=> '',
            ],
        ]
    ]
];