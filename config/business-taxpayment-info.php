<?php
return [
    "fnc_create_businesstaxpaymentstatus"=>"
        DROP FUNCTION IF EXISTS fnc_businesstaxpaymentstatus();
        CREATE OR REPLACE FUNCTION fnc_businesstaxpaymentstatus()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            DROP TABLE IF EXISTS business_tax_payment_status CASCADE;
                
            CREATE TABLE business_tax_payment_status AS
            SELECT btp.id as business_tax_payment_id, b.registration as registration, b.ward,  
                CASE 
                    WHEN btp.tax_paid_end_at is NULL THEN 99    
                    WHEN btp.tax_paid_end_at is not NULL THEN 
                    CASE
                        WHEN date_part('year', AGE(ndt.fiscal_year_end::date, btp.tax_paid_end_at::date))::int > 5 THEN 5
                        ELSE date_part('year', AGE(ndt.fiscal_year_end::date, btp.tax_paid_end_at::date))::int
                    END
                END as due_year,  
                Case 
                    WHEN btp.registration is not NULL AND b.registration is not NULL THEN TRUE
                    WHEN btp.registration is NULL or b.registration is NULL THEN False
                End as match,
                b.geom, Now() as created_at, Now() as updated_at
            FROM business_tax_payments btp LEFT join bldg_business_tax b on btp.registration=b.registration
            CROSS JOIN nepali_date_today ndt;
            Return True
        ;
        END
        $$;
    ",
];