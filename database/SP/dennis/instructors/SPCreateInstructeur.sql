CREATE PROCEDURE SPCreateInstructeur(
    IN p_first_name VARCHAR(255),
    IN p_middle_name VARCHAR(255),
    IN p_last_name VARCHAR(255),
    IN p_birth_date DATE,
    IN p_street_name VARCHAR(255),
    IN p_house_number VARCHAR(255),
    IN p_addition VARCHAR(255),
    IN p_postal_code VARCHAR(255),
    IN p_city VARCHAR(255),
    IN p_email VARCHAR(255)
)
BEGIN
    DECLARE v_user_id BIGINT;
    DECLARE v_instructor_number VARCHAR(10);
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    -- Generate new instructor number
    SELECT CONCAT('INST', LPAD(
        COALESCE(MAX(CAST(SUBSTRING(number, 5) AS UNSIGNED)), 0) + 1, 
        3, '0'
    )) INTO v_instructor_number
    FROM instructors;

    -- Insert into users table
    INSERT INTO users (
        username,
        password,  -- Toegevoegd password veld
        first_name, 
        middle_name, 
        last_name, 
        birth_date, 
        created_at, 
        updated_at
    )
    VALUES (
        p_email,
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',  -- Gehashte waarde voor 'password'
        p_first_name, 
        NULLIF(p_middle_name, ''), 
        p_last_name, 
        p_birth_date, 
        NOW(), 
        NOW()
    );

    SET v_user_id = LAST_INSERT_ID();

    -- Insert into contacts
    INSERT INTO contacts (
        user_id, street_name, house_number, addition, 
        postal_code, city, email, is_active, created_at, updated_at
    )
    VALUES (
        v_user_id,
        p_street_name,
        p_house_number,
        NULLIF(p_addition, ''),
        p_postal_code,
        p_city,
        p_email,
        1,
        NOW(),
        NOW()
    );

    -- Insert into instructors
    INSERT INTO instructors (user_id, number, is_active, created_at, updated_at)
    VALUES (v_user_id, v_instructor_number, 1, NOW(), NOW());

    COMMIT;

    -- Return the newly created instructor data
    SELECT 
        user.first_name,
        user.middle_name,
        user.last_name,
        user.birth_date,
        cont.full_address,
        cont.email,
        inst.number
    FROM instructors inst
    INNER JOIN users user ON inst.user_id = user.id
    INNER JOIN contacts cont ON cont.user_id = user.id
    WHERE inst.user_id = v_user_id;
END
