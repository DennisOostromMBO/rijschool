DROP PROCEDURE IF EXISTS UpdateInvoice;

CREATE PROCEDURE UpdateInvoice(
    IN p_id INT,
    IN p_invoice_number VARCHAR(255),
    IN p_invoice_date DATE,
    IN p_registration_id INT,
    IN p_invoice_status VARCHAR(50),
    IN p_amount_excl_vat DECIMAL(10,2),
    IN p_vat DECIMAL(5,2),
    IN p_amount_incl_vat DECIMAL(10,2),
    IN p_remark TEXT
)
BEGIN
    UPDATE invoices
    SET
        invoice_number = p_invoice_number,
        invoice_date = p_invoice_date,
        registration_id = p_registration_id,
        invoice_status = p_invoice_status,
        amount_excl_vat = p_amount_excl_vat,
        vat = p_vat,
        amount_incl_vat = p_amount_incl_vat,
        remark = p_remark,
        updated_at = NOW()
    WHERE id = p_id;
END;
