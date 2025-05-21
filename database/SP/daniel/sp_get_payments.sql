DROP PROCEDURE IF EXISTS GetPayments;

CREATE PROCEDURE GetPayments()
BEGIN
    SELECT 
        payments.id AS payment_id,
        invoices.invoice_number,
        invoices.invoice_date,
        invoices.amount_incl_vat,
        payments.status AS payment_status,
        users.Full_name AS payer_name -- Changed from full_name to name for consistency
    FROM payments
    JOIN invoices ON payments.invoice_id = invoices.id
    JOIN registrations ON invoices.registration_id = registrations.id
    JOIN students ON registrations.student_id = students.id
    JOIN users ON students.user_id = users.id
    ORDER BY invoices.invoice_date DESC;
END;