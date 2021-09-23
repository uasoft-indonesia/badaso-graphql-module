### Query And Mutation Add New Field
```
$fields['name_field_query_or_mutation'] = ['type' => Type::string(), 'resolve' => function ($root_value, $args) { }];
```
or
```
$fields['name_field_query_or_mutation'] = [
    'type' => new ObjectType([
        'name' => 'example_type',
        'fields' => [
            'field1' => Type::string(),
            'field2' => [
                'type' => Type::string(),
                'description' => 'description for field2'
            ]
        ]
    ]),
    'resolve' => function ($root_value, $args) {
        return [
            'field1' => 'output field1',
            'field2' => 'output field2'
        ];
    }
];
```
or
```
$fields['name_field_query_or_mutation'] = [
    'type' => new ObjectType([
        'name' => 'example_type',
        'fields' => [
            'field1' => Type::string(),
            'field2' => [
                'type' => Type::string(),
                'description' => 'description for field2'
            ]
        ]
    ]),
    'args' => [
        'input1' => [
            'type' => Type::string(),
        ],
        'input2' => Type::string(),
        'input3' => [
            'type' => new InputObjectType([
                'name' => 'parameter_input_3',
                'fields' => [
                    'input_parameter_1' => Type::string(),
                    'input_parameter_2' => [
                        'type' => Type::string(),
                        'description' => 'description input parameter 2'
                    ]
                ],
            ]),
        ],
    ],
    'resolve' => function ($root_value, $args) {
        return [
            'field1' => 'output field1 '.$args['input1'],
            'field2' => 'output field2 '.$args['input2'],
        ];
    }
];
```

### How Call Example
```
[query|mutation]{
	field_name_mutation(
    input1: "input 1",
    input2: "input 2",
    input3: {
      input_parameter_1 : "input paramerer 1",
      input_parameter_2 : "input parameter 2"
    }
  ){
    field2
    field1
  }
}
```

### Structure Type, Query, and Mutation
```
Schema {
    query : ObjectType {
        name: "name",
        fields: [
            field1 : {
                type: ObjectType { ... }
                resolve: function(rootValue, args){
                    return ObjectType
                }
            },
            field2 : {
                type: string | bool | integer | double
                resolve : function(rootValue, args){
                    return string | bool | integer | double
                }
            },
            field3 : {
                type: ObjectType {
                    name : "object1",
                    fields : [
                        subObjet1 : string | bool | integer | double
                        subObject2 : {
                            type : string | bool | integer | double
                        },
                        subObject3 : ObjectType {
                            name : 'sub_object_1',
                            fields : [
                                subSubObjet1 : string | bool | integer | double
                                subSubObject2 : {
                                    type : string | bool | integer | double
                                },
                                subSubObject3 : ObjectType { ... }
                            ],
                            resolve : function(rootValue, args) {
                                return ObjectType // from object sub_object_1
                            }
                        }
                    ]
                }
                args: [
                    param1 : string | bool | integer | double
                    param2 : InputType {
                        name : "param2"
                        fields : [
                            param1 : string | bool | integer | double,
                            param2 : InputType { ... }
                        ]
                    }
                ]
                resolve: function(rootValue, args){
                    return ObjectType
                }
            },
        ]
    }
}
```

### Output Final Query And Mutation
```
$schema = new Schema([
    'query' =>  new ObjectType([
        'name' => 'Query',
        'fields' => [
            'name_field_query_or_mutation' => [
                'type' => new ObjectType([
                    'name' => 'example_type',
                    'fields' => [
                        'field1' => Type::string(),
                        'field2' => [
                            'type' => Type::string(),
                            'description' => 'description for field2'
                        ]
                    ]
                ]),
                'args' => [
                    'input1' => [
                        'type' => Type::string(),
                    ],
                    'input2' => Type::string(),
                    'input3' => [
                        'type' => new InputObjectType([
                            'name' => 'parameter_input_3',
                            'fields' => [
                                'input_parameter_1' => Type::string(),
                                'input_parameter_2' => [
                                    'type' => Type::string(),
                                    'description' => 'description input parameter 2'
                                ]
                            ],
                        ]),
                    ],
                ],
                'resolve' => function ($root_value, $args) {
                    return [
                        'field1' => 'output field1 '.$args['input1'],
                        'field2' => 'output field2 '.$args['input2'],
                    ];
                }
            ]
        ]
    ])
    'mutation' => new ObjetType([
        'name' => 'Mutation',
        'fields' => [
            'name_field_query_or_mutation' => [
                'type' => new ObjectType([
                    'name' => 'example_type',
                    'fields' => [
                        'field1' => Type::string(),
                        'field2' => [
                            'type' => Type::string(),
                            'description' => 'description for field2'
                        ]
                    ]
                ]),
                'args' => [
                    'input1' => [
                        'type' => Type::string(),
                    ],
                    'input2' => Type::string(),
                    'input3' => [
                        'type' => new InputObjectType([
                            'name' => 'parameter_input_3',
                            'fields' => [
                                'input_parameter_1' => Type::string(),
                                'input_parameter_2' => [
                                    'type' => Type::string(),
                                    'description' => 'description input parameter 2'
                                ]
                            ],
                        ]),
                    ],
                ],
                'resolve' => function ($root_value, $args) {
                    return [
                        'field1' => 'output field1 '.$args['input1'],
                        'field2' => 'output field2 '.$args['input2'],
                    ];
                }
            ]
        ]
    ])
])
```
