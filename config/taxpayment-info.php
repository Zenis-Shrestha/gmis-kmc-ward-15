<?php
return [

    "fnc_create_bldgtaxpaymentstatus"=>"
        DROP FUNCTION IF EXISTS fnc_bldgtaxpaymentstatus();
        CREATE OR REPLACE FUNCTION fnc_bldgtaxpaymentstatus()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            DROP TABLE IF EXISTS bldg_tax_payment_status CASCADE;
                
            CREATE TABLE bldg_tax_payment_status AS
            SELECT btp.id as tax_payment_id, b.bin as bin, b.ward,  
                CASE 
                    WHEN btp.tax_paid_end_at is NULL THEN 99    
                    WHEN btp.tax_paid_end_at is not NULL THEN 
                    CASE
                        WHEN date_part('year', AGE(ndt.fiscal_year_end::date, btp.tax_paid_end_at::date))::int > 5 THEN 5
                        ELSE date_part('year', AGE(ndt.fiscal_year_end::date, btp.tax_paid_end_at::date))::int
                    END
                END as due_year,  
                Case 
                    WHEN btp.bin is not NULL AND b.bin is not NULL THEN TRUE
                    WHEN btp.bin is NULL or b.bin is NULL THEN False
                End as match,
                b.geom, Now() as created_at, Now() as updated_at
            FROM bldg_tax_payments btp LEFT join bldg b on btp.bin=b.bin
            CROSS JOIN nepali_date_today ndt ON dt.id = 1;
           
            
            Return True
        ;
        END
        $$;
    "
];