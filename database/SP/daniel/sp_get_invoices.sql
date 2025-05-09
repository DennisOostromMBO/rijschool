DROP PROCEDURE IF EXISTS GetInvoices;

CREATE PROCEDURE GetInvoices()
BEGIN
    SELECT 
        invoices.id,
        invoices.invoice_number,
        invoices.invoice_date,
        invoices.invoice_status,
        invoices.amount_incl_vat,
        users.full_name AS student_name 
    FROM invoices
    JOIN registrations ON invoices.registration_id = registrations.id
    JOIN students ON registrations.student_id = students.id
    JOIN users ON students.user_id = users.id
    ORDER BY invoices.created_at DESC;
END;