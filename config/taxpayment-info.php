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
            CROSS JOIN nepali_date_today ndt;
           
            
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
            ALTER TABLE building_info.owners DROP CONSTRAINT IF EXISTS owners_tax_id_unique;
            ALTER TABLE building_info.owners ADD CONSTRAINT owners_tax_id_unique UNIQUE (tax_id);

            with tax_data as (
                SELECT t.tax_id, t.owner_name, t.gender, t.contact_no
                FROM bldg_tax_payment_status t 
                Left Join building_info.owners o ON o.tax_id = t.tax_id 
                WHERE t.building_associated_to is NULL
            )
            INSERT INTO building_info.owners (tax_id, owner_name, gender, contact_no, created_at)
                SELECT tax_id, owner_name, gender, contact_no, NOW() FROM tax_data
                ON CONFLICT ON CONSTRAINT owners_tax_id_unique
                DO 
                UPDATE SET tax_id=excluded.tax_id, owner_name = excluded.owner_name, gender = excluded.gender, contact_no = excluded.contact_no, updated_at=NOW();
                
            Return True
        ;
        END
        $$;
    ",

    "fnc_create_wardproportion"=>"DROP FUNCTION IF EXISTS fnc_create_wardproportion();    
    CREATE OR REPLACE FUNCTION fnc_create_wardproportion()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            DROP MATERIALIZED VIEW IF EXISTS ward_proportion;
                    
            CREATE MATERIALIZED VIEW ward_proportion AS 
                SELECT w.ward,  a.count, b.totalcount,
                    ROUND(a.count * 100/b.totalcount::numeric, 2 ) as proportion
                FROM ( 
                    SELECT ward, count(*) as count
                    FROM bldg_tax_payment_status  
                    WHERE due_year = 0 
                        AND building_associated_to is NULL 
                       
                    GROUP BY ward
                ) a
                JOIN ( 
                    SELECT ward, count(*) as totalcount
                    FROM bldg_tax_payment_status 
                    WHERE building_associated_to is NULL 
                       
                    GROUP BY ward
                ) b ON b.ward = a.ward
                RIGHT JOIN 
                    layer_info.wards w
                    ON b.ward = w.ward
                ORDER BY b.ward asc;
                
        Return True
    ;
    END
    $$;",

    "fnc_create_gridproportion"=>"DROP FUNCTION IF EXISTS fnc_create_gridproportion();    
    CREATE OR REPLACE FUNCTION fnc_create_gridproportion()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            DROP MATERIALIZED VIEW IF EXISTS grid_proportion;
                    
            CREATE MATERIALIZED VIEW grid_proportion AS 
                SELECT gg.id as grid,  a.count, b.totalcount,
                    ROUND(a.count * 100/b.totalcount::numeric, 2 ) as proportion
                FROM ( 
                    SELECT g.id, count(t.bin) as count
                    FROM bldg_tax_payment_status t, layer_info.grids g
                    WHERE ST_Contains(ST_Transform(g.geom, 4326), t.geom)
                        AND t.due_year = 0 
                        AND t.building_associated_to is NULL 
                        
                    GROUP BY g.id
                ) a
                JOIN ( 
                    SELECT  g.id, count(t.bin) as totalcount
                    FROM bldg_tax_payment_status t, layer_info.grids g
                    WHERE ST_Contains(ST_Transform(g.geom, 4326), t.geom)
                        AND t.building_associated_to is NULL 
                      
                    GROUP BY g.id
                ) b ON b.id = a.id
                RIGHT JOIN 
                        layer_info.grids gg
                        ON b.id = gg.id
                ORDER BY gg.id asc;
                
        Return True
    ;
    END
    $$;",

    "fnc_updonimprt_gridnward_tax"=>"DROP FUNCTION IF EXISTS fnc_updonimprt_gridnward_tax();    
    CREATE OR REPLACE FUNCTION fnc_updonimprt_gridnward_tax()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            UPDATE layer_info.wards SET bldgtaxpdprprtn = 0;
            UPDATE layer_info.wards w 
            SET bldgtaxpdprprtn = q.percentage_proportion
            FROM (
                    SELECT a.ward,  a.count, b.totalcount,
                    ROUND(a.count * 100/b.totalcount::numeric, 2 ) as percentage_proportion
                FROM ( 
                    select ward, count(*) as count
                    FROM bldg_tax_payment_status  
                    WHERE due_year = 0 
                        AND building_associated_to is NULL 
                       
                    GROUP BY ward
                ) a
                JOIN ( 
                    select ward, count(*) as totalcount
                    FROM bldg_tax_payment_status 
                    WHERE building_associated_to is NULL 
                       
                    GROUP BY ward
                ) b ON b.ward = a.ward
                ORDER BY a.ward asc
            ) as q
            WHERE w.ward = q.ward;
                
            UPDATE layer_info.grids SET bldgtaxpdprprtn = 0;
            UPDATE layer_info.grids g
            SET bldgtaxpdprprtn = q.percentage_proportion
            FROM (
                SELECT a.id,  a.count, b.totalcount,
                    ROUND(a.count * 100/b.totalcount::numeric, 2 ) as percentage_proportion
                FROM ( 
                    SELECT g.id, count(t.bin) as count
                    FROM bldg_tax_payment_status t, layer_info.grids g
                    WHERE ST_Contains(ST_Transform(g.geom, 4326), t.geom)
                        AND t.due_year = 0 
                        AND t.building_associated_to is NULL 
                        
                    GROUP BY g.id
                ) a
                JOIN ( 
                    SELECT  g.id, count(t.bin) as totalcount
                    FROM bldg_tax_payment_status t, layer_info.grids g
                    WHERE ST_Contains(ST_Transform(g.geom, 4326), t.geom)
                        AND t.building_associated_to is NULL 
                       
                    GROUP BY g.id
                ) b ON b.id = a.id
                ORDER BY a.id asc
            )as q
            WHERE g.id = q.id;
                
        Return True
    ;
    END
    $$;"

];