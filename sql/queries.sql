-- nodes with body field data only. Need to join other fields for each specific node
SELECT n.nid, n.type, fdb.entity_type, fdb.bundle, fdb.entity_id FROM node n
INNER JOIN field_data_body fdb ON (n.nid = fdb.entity_id) LIMIT 10

-- Paragraphs-pack-content data paragraphs_item might not be needed
SELECT * FROM field_data_pp_body b
INNER JOIN paragraphs_item p ON p.item_id = b.entity_id
INNER JOIN field_data_field_class c on b.entity_id = c.entity_id
