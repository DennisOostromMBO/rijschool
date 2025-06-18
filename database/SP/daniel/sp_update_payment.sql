DROP PROCEDURE IF EXISTS UpdatePayment;

CREATE PROCEDURE UpdatePayment(
    IN p_id INT,
    IN p_invoice_id INT,
    IN p_date DATE,
    IN p_amount DECIMAL(10,2),
    IN p_payment_method VARCHAR(50),
    IN p_status VARCHAR(50),
    IN p_is_active TINYINT(1),
    IN p_remark TEXT,
    IN p_reference_number VARCHAR(100)
)
BEGIN
    UPDATE payments
    SET
        invoice_id = p_invoice_id,
        date = p_date,
        amount = p_amount,
        payment_method = p_payment_method,
        status = p_status,
        is_active = p_is_active,
        remark = p_remark,
        reference_number = p_reference_number,
        updated_at = NOW()
    WHERE id = p_id;
END;
