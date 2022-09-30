INSERT INTO platform
VALUES
	(NULL, 'AWS'),
    (NULL, 'Azure')
;

INSERT INTO customer
VALUES
	(NULL, 'John'),
    (NULL, 'Steve')
;

INSERT INTO user_role
VALUES
	(NULL, 'Manager'),
    (NULL, 'Auditer')
;

INSERT INTO resource_type
VALUES
	(NULL, 'resourceType1', 1),
    (NULL, 'resourceType2', 2)
;

INSERT INTO account
VALUES
	(NULL, 'account_ref_1', 1, 1),
    (NULL, 'account_ref_2', 2, 2)
;

INSERT INTO user
VALUES
	(NULL, 'John123', 1, 1),
    (NULL, 'Stevo', 2, 2)
;

INSERT INTO resource
VALUES
	(NULL, 'resource_ref_01', 1, 1, 'resource_name_1', '11/9/22', 'random Json stuff'),
    (NULL, 'resource_ref_02', 2, 2, 'resource_name_2', '18/7/22', 'more random Json stuff')
;

INSERT INTO rule
VALUES
	(NULL, 'rule name 1', 1),
    (NULL, 'rule name 2', 2)
;

INSERT INTO non_complience_audit
VALUES
	(NULL, 1, 1, 1, 'action1', '14/07/22'),
    (NULL, 2, 2, 2, 'action2', '12/06/22')
;

INSERT INTO exception
VALUES
	(NULL, 1, 1, 1, 'exception_value_1', 'justification', '10/1/23', '10/8/22'),
    (NULL, 2, 2, 2, 'exception_value_2', 'another justification', '12/2/23', '22/6/22')
;
    
INSERT INTO exception_audit
VALUES
	(NULL, 1, 1, 1, 1, '12/12/22', 'old_exception_value1', 'new_exception_value1', 'old_justification1', 'new_justification1', '10/1/23', '10/8/22'),
    (NULL, 2, 2, 2, 2, '12/11/22', 'old_exception_value2', 'new_exception_value2', 'old_justification2', 'new_justification2', '10/2/23', '10/9/22')
;
    
    
