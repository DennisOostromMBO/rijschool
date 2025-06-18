DROP PROCEDURE IF EXISTS CreatePayment;

CREATE PROCEDURE CreatePayment(
    IN p_invoice_id INT,
    IN p_date DATE,
    IN p_status VARCHAR(255),
    IN p_is_active BOOLEAN,
    IN p_remark TEXT
)
BEGIN
    INSERT INTO payments (
        invoice_id,
        date,
        status,
        is_active,
        remark,
        created_at,
        updated_at
    ) VALUES (
        p_invoice_id,
        p_date,
        p_status,
        p_is_active,
        p_remark,
        NOW(),
        NOW()
    );
END;

