DROP PROCEDURE IF EXISTS CreatePayment;

CREATE PROCEDURE CreatePayment(
    IN p_invoice_id INT,
    IN p_date DATE,
    IN p_amount DECIMAL(10,2),
    IN p_payment_method VARCHAR(50),
    IN p_status VARCHAR(50),
    IN p_remark TEXT,
    IN p_reference_number VARCHAR(100)
)
BEGIN
    INSERT INTO payments (
        invoice_id,
        date,
        amount,
        payment_method,
        status,
        remark,
        reference_number,
        created_at,
        updated_at
    ) VALUES (
        p_invoice_id,
        p_date,
        p_amount,
        p_payment_method,
        p_status,
        p_remark,
        p_reference_number,
        NOW(),
        NOW()
    );
END;

