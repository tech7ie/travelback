<?php

print_r( json_encode( [
    'failed'   => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'home_title'     => 'Every detail matters,<br>although detail is just a word.',
    'home_sub_title' => '<b>8000+ available routes</b><span>Choose the most effective option to get where you need.</span>',
    'password'       => 'The provided password is incorrect.',
    'throttle'       => 'Too many login attempts. Please try again in :seconds seconds.',
    'block_1'        => [
        '1' => '<b>From A to B service</b><span>Get easily from your starting to the final spot.</span>',
        '2' => '<b>Guidance of locals</b><span>Our drivers will take you to places, introduce traditions and give information of the place you are heading towards.</span>'
    ],
    'block_2'        => [
        '1' => '<b>Giving a hand with the luggage</b>
                        <p>Reservations may be achieved by just a single click. Due to our easily understandable system and structure of the website, your reservation will be completed in a few seconds. Free cancellation up to 24 hours before the journey. We understand that traveling always brings up unexpected changes.</p>',
        '2' => '<b>Guidance of locals</b>
                        <p>Our drivers will take you to places, introduce traditions and give information of the place you are heading towards. Every driver, who is a member of mytripline company, is trained also as a guide and in that respect he is educated about each destination. Living in those regions, our drivers are mainly locals and know the most about their homes.</p>',
        '3' => '<b>The driver becomes your personal guide</b>
                        <p>Every driver working for us speaks English fluently and endeavours to keep an eye on the most interesting spots passed along the journey.</p>'
    ],
    'block_3'        => [
        '1' => '<em>Our motto says:</em>
                    <h3>«Every detail matters, although detail is just a word. We have given it true meaning»</h3>
                    <p>Every detail matter, even though detail is just a word. We have given it true meaning, “and in that respect each moment of your jouney and each day counts and makes difference when thought through in detail. Drivers aim to fulfil your full enjoyment of the experience.</p>'
    ],

    'block_places_slider'   => 'We have nothing to lose and a world to see',
    'block_4'               => [
        'title' => 'Effective bookings',
        '1'     => '<h4>Reservations may be achieved by just a single click.</h4>
                <p>Due to our easily understandable system and structure of the website, your reservation will be completed in a few seconds.</p>',

        '2' => '<h6>Free cancellation up to 24 hours before the journey.</h6>
                <p>We understand that travelling always brings up unexpected changes.</p>'
    ],
    'block_partners_slider' => 'Partners',
    'block_5'               => [
        'title' => 'Choose us',
        '1'     => '<h3>Safety.</h3>
                            <p>Each driver working for MYTRIPLINE has gone through the strict selection procedure. Speaking of our highest aim, getting your from A to B point while offering the greatest possible comfort meets up your and our desire. Time spent on getting to your final point does not have to be time wasted. With us it is simply enjoyable.</p>',

        '2' => '<h3>Quality.</h3>
                            <p>To our precious clients, Mytripline guarantees every single ride to be a comfortable and delightful experience when facilitated through our company. In this respect, we pay full attention to the quality and cleanliness of our vehicles and driver selection, who will become your guide throughtout the journey.</p>',
        '3' => '<h3>Reliability.</h3>
                            <p>The journey always sets off on time. Our drivers will get you from A to B point while choosing the most comfortable route from multiple possibilities. This journey provided by our company also adds the best stops at must-see destinations.</p>',
    ],
    'block_6'               => [
        'title' => 'Countries where we work'
    ],
    'VIDEO'                 => 'VIDEO',

    'routes'           => 'Routes',
    'select_a_country' => 'Every detail matters,<br>although detail is just a word.',
    'search'           => 'Search',

    'company'          => 'Company',
    'discover'         => 'Discover',
    'routes'           => 'Routes',
    'become_a_partner' => 'Become a partner',
    'about'            => 'About',
    'terms_of_use'     => 'Terms of use',
    'privacy_policy'   => 'Privacy policy',


    'previous' => '&laquo; Previous',
    'next'     => 'Next &raquo;',

    'reset'       => 'Your password has been reset!',
    'sent'        => 'We have emailed your password reset link!',
    'throttled'   => 'Please wait before retrying.',
    'token'       => 'This password reset token is invalid.',
    'user'        => "We can't find a user with that email address.",
    'beginning'   => '<b>Beginning</b><span>Your driver will arrive at the starting point</span>',
    'extra_stops' => '<b>Extra stops</b><span>During the ride, you will stop to sightsee a city</span>',
    'finish_ride' => '<b>Finish ride</b><span>Completing the ride with your driver who will help with your baggage up to a hotel/boat/airport</span>',

    'calculator' =>
        [
            'title' => 'One way',
        ],


    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute must only contain letters.',
    'alpha_dash'           => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'The :attribute must only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'current_password'     => 'The password is incorrect.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_equals'          => 'The :attribute must be a date equal to :date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'ends_with'            => 'The :attribute must end with one of the following: :values.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file'    => 'The :attribute must not be greater than :max kilobytes.',
        'string'  => 'The :attribute must not be greater than :max characters.',
        'array'   => 'The :attribute must not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'multiple_of'          => 'The :attribute must be a multiple of :value.',
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'password'             => 'The password is incorrect.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values are present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'prohibited'           => 'The :attribute field is prohibited.',
    'prohibited_if'        => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless'    => 'The :attribute field is prohibited unless :other is in :values.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',
    'uuid'                 => 'The :attribute must be a valid UUID.',

    'custom'     => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    'attributes' => [],
] ) );
