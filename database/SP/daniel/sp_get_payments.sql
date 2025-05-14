DROP PROCEDURE IF EXISTS GetPayments;

CREATE PROCEDURE GetPayments()
BEGIN
    SELECT 
        payments.id,
        payments.payment_number,
        payments.payment_date,
        payments.amount,
        payments.payment_status,
        payments.invoice_id, 
        invoices.invoice_date, 
        users.full_name AS payer_name
    FROM payments
    JOIN invoices ON payments.invoice_id = invoices.id
    JOIN users ON invoices.registration_id = users.id
    ORDER BY payments.payment_date DESC;
END;