use produtos;

create table produtos (
id int not null auto_increment,
produto varchar(255) not null,
valor float not null,
dataCadastro datetime default current_timestamp not null,
primary key(id)
)default charset = utf8;


