DROP PROCEDURE IF EXISTS CreateInvoice;

CREATE PROCEDURE CreateInvoice(
    IN p_registration_id INT,
    IN p_invoice_number VARCHAR(255),
    IN p_invoice_date DATE,
    IN p_amount_excl_vat DECIMAL(10,2),
    IN p_vat DECIMAL(5,2),
    IN p_amount_incl_vat DECIMAL(10,2),
    IN p_invoice_status VARCHAR(50),
    IN p_is_active TINYINT(1),
    IN p_remark TEXT
)
BEGIN
    INSERT INTO invoices (
        registration_id,
        invoice_number,
        invoice_date,
        amount_excl_vat,
        vat,
        amount_incl_vat,
        invoice_status,
        is_active,
        remark,
        created_at,
        updated_at
    ) VALUES (
        p_registration_id,
        p_invoice_number,
        p_invoice_date,
        p_amount_excl_vat,
        p_vat,
        p_amount_incl_vat,
        p_invoice_status,
        p_is_active,
        p_remark,
        NOW(),
        NOW()
    );
END;
