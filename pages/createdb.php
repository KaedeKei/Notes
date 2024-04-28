<?php
include_once("functions.php");
$link = connect();

$ct1 = "create table roles(
    id int not null auto_increment primary key,
    role varchar(32)
)";

$ct2 = "create table users(
    id int not null auto_increment primary key,
    login varchar(32) unique,
    pass varchar(128),
    email varchar(128),
    roleid int,
    foreign key(roleid) references roles(id) on delete cascade
)";

$ct3 = "create table notes(
    id int not null auto_increment primary key,
    notes_title varchar(128) NOT NULL,
    notes_text varchar(1024) NOT NULL,
    userid int,
    foreign key(userid) references users(id) on delete cascade
)";

if ($link->query($ct1)) {
    echo "Таблица Roles успешно создана";
} else {
    echo "Ошибка: " . $link->error;
}

if ($link->query($ct2)) {
    echo "Таблица Users успешно создана";
} else {
    echo "Ошибка: " . $link->error;
}

if ($link->query($ct3)) {
    echo "Таблица Notes успешно создана";
} else {
    echo "Ошибка: " . $link->error;
}

$link->close();
