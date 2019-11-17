CREATE DATABASE up_losarang;

USE up_losarang;

CREATE TABLE satuan(
    kd_satuan varchar (6)not null primary key,
    nm_satuan varchar (45) not null
)ENGINE=INNODB;

CREATE TABLE satuan_konversi(
    kd_konversi varchar (6)not null primary key,
    kd_satuan varchar (6) not null,
    nilai_konversi int(11) not null,
    nm_konversi varchar (45) not null,
    FOREIGN KEY (kd_satuan)
    REFERENCES satuan (kd_satuan)
)ENGINE=INNODB;

CREATE TABLE produk(
    kd_produk varchar (6)not null primary key,
    nm_produk varchar (45) not null,
    qty int(11) not null,
    kd_konversi varchar (6) not null,
    hrg_beli INT (11),
    hrg_jual int (11),
    FOREIGN KEY (kd_konversi) 
    REFERENCES satuan_konversi (kd_konversi)
)ENGINE=INNODB;

CREATE TABLE trb(
    no_trb int (11) not null primary key,
    tgl_trb date not null,
    wkt_trb time not null,
    total_trb int (11) not null,
    uraian_trb text
)ENGINE=INNODB;

CREATE TABLE trb_produk(
    no_trb int (11) not null,
    kd_produk varchar (6) not null,
    qty_trb_produk int(11) not null,
    satuan_trb varchar (6) not null,
    hrg_trb int (11) not null,
    subtotal_trb int (11) not null,
    FOREIGN KEY (no_trb) REFERENCES trb (no_trb),
    FOREIGN KEY (kd_produk) REFERENCES produk (kd_produk),
    FOREIGN KEY (satuan_trb) REFERENCES satuan_konversi (kd_konversi)
)ENGINE=INNODB;

CREATE TABLE pengeluaran(
    kd_pengeluaran varchar (6) not null primary key,
    nm_pengeluaran varchar (45) not null
)ENGINE=INNODB;

CREATE TABLE trb_pengeluaran(
    no_trb int (11) not null,
    kd_pengeluaran varchar (6) not null,
    qty_trb_pengeluaran int(11) not null,
    hrg_trb_pengeluaran int (11) not null,
    subtotal_trb_pengeluaran int (11) not null,
     FOREIGN KEY (no_trb) REFERENCES trb (no_trb),
     FOREIGN KEY (kd_pengeluaran) REFERENCES pengeluaran (kd_pengeluaran)
)ENGINE=INNODB;

CREATE TABLE trj(
    no_trj int (11) not null primary key,
    tgl_trj date not null,
    wkt_trj time not null,
    total_trj int (11) not null,
    uraian_trj text   
)ENGINE=INNODB;

CREATE TABLE trj_produk(
    no_trj int (11) not null,
    kd_produk varchar (6) not null,
    qty_trj_produk int(11) not null,
    satuan_trj varchar (6) not null,
    hrg_trj INT (11),
    subtotal_trj int (11),
    FOREIGN KEY (no_trj) REFERENCES trj (no_trj),
    FOREIGN KEY (kd_produk) REFERENCES produk (kd_produk),
    FOREIGN KEY (satuan_trj) REFERENCES satuan_konversi (kd_konversi)
)ENGINE=INNODB;

CREATE TABLE pemasukan(
    kd_pemasukan varchar (6) not null primary key,
    nm_pemasukan varchar (45) not null
)ENGINE=INNODB;

CREATE TABLE trj_pemasukan(
    no_trj int (11) not null,
    kd_pemasukan varchar (6) not null,
    qty_trj_pemasukan int(11) not null,
    hrg_trj_pemasukan varchar (6) not null,
    subtotal_trj_pemasukan int (11),
    FOREIGN KEY (no_trj) REFERENCES trj (no_trj),
    FOREIGN KEY (kd_pemasukan) REFERENCES pemasukan (kd_pemasukan)
)ENGINE=INNODB;