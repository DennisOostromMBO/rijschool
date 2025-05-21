CREATE PROCEDURE SPGetAllStudents()
BEGIN
    SELECT 
        users.full_name,
        users.birth_date,
        students.relation_number,
        contacts.full_address,
        contacts.mobile,
        contacts.email
    FROM students
    INNER JOIN users ON students.user_id = users.id
    INNER JOIN contacts ON contacts.user_id = users.id;
END;


