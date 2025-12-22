Table serial_number {
  qr_code bigint [pk]
}

Table user_information {
  user_id int [pk, increment]

  username varchar(50) [not null, unique]
  password_hash varchar(255) [not null]

  user_email varchar(100)
  user_phone varchar(20)
  user_address varchar(100)

  balance decimal(10,2) [default: 0]
  points int [default: 0]

  qr_code bigint
  created_at timestamp [default: `CURRENT_TIMESTAMP`]
}

Table material {
  material_id int [pk, increment]

  user_id int [not null]
  material_type varchar(50) [not null]
  quantity int [not null]

  created_at timestamp [default: `CURRENT_TIMESTAMP`]
}

Table factory {
  factory_id int [pk, increment]

  factory_name varchar(200) [not null]
  factory_location varchar(200)

  qr_code bigint
}

Table driver {
  driver_id int [pk, increment]

  username varchar(50) [not null, unique]
  password_hash varchar(255) [not null]

  driver_name varchar(50)
  driver_phone varchar(20)
  driver_email varchar(100)

  qr_code bigint
}



Ref: user_information.qr_code > serial_number.qr_code
Ref: driver.qr_code > serial_number.qr_code
Ref: factory.qr_code > serial_number.qr_code

Ref: material.user_id > user_information.user_id