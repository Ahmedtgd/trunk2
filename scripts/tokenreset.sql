truncate userstoken;
truncate tokenlog;
truncate invoicepayment;
truncate freetokenslog;
delete from porder where id in (select porder_id from invoice);
truncate invoice;

