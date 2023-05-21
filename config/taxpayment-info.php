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
            SELECT btp.id as bldg_tax_payments_id, b.bin as bin, b.ward,  
                Case 
                    WHEN btp.owner_name is not NULL THEN btp.owner_name
                    ELSE b.hownr
                End as owner_name,
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
            FROM bldg b LEFT JOIN bldg_tax_payments btp on btp.bin=b.bin
            CROSS JOIN nepali_date_today ndt WHERE ndt.id = 1;
            
            Return True
        ;
        END
        $$;
    ",
    "fnc_insrtupd_taxbuildowner"=>"
        -- DROP FUNCTION IF EXISTS fnc_insrtupd_taxbuildowner();    
        CREATE OR REPLACE FUNCTION fnc_insrtupd_taxbuildowner()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            ALTER TABLE bldg_owners DROP CONSTRAINT IF EXISTS bldg_owners_bin_unique;
            ALTER TABLE bldg_owners ADD CONSTRAINT bldg_owners_bin_unique UNIQUE (bin);

            with tax_data as (
                SELECT t.bin, t.owner_name
                FROM bldg_tax_payment_status t 
                Left Join bldg_owners o ON o.bin = t.bin 
                
            )
            INSERT INTO bldg_owners (bin, owner_name, created_at)
                SELECT bin, owner_name, NOW() FROM tax_data
                ON CONFLICT ON CONSTRAINT bldg_owners_bin_unique
                DO 
                UPDATE SET bin=excluded.bin, owner_name = excluded.owner_name, updated_at=NOW();
                
            Return True
        ;
        END
        $$;
    "
];