truncate tproduct;
truncate tproductdealer;
truncate tproductdetail;
truncate merchanttproduct;
truncate ntproductid;
truncate ordertproduct;
delete from porder where id in (select porder_id from invoice);
truncate invoice;
truncate invoicepayment;
