cd\ 
cd wamp\bin\mysql\mysql5.6.17\bin 
mysqldump -uroot  -h 127.0.0.1 --no-create-info --replace db_pos menu_category menu_item restaurant user > dump_transfer_master.sql 
mysql -uroot  db_pos < dump_transfer_master.sql