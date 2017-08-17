-- nodes with body field data only. Need to join other fields for each specific node
SELECT n.nid, n.type, fdb.entity_type, fdb.bundle, fdb.entity_id FROM node n
INNER JOIN field_data_body fdb ON (n.nid = fdb.entity_id) LIMIT 10

-- Paragraphs-pack-content content
SELECT p.item_id, b.entity_id, c.entity_id, c.field_class_value FROM paragraphs_item p
INNER JOIN field_data_pp_body b ON (p.item_id = b.entity_id)
INNER JOIN field_data_field_class c on c.entity_id = p.item_id

SELECT p.item_id, b.entity_id, b.field_class_value FROM paragraphs_item p INNER JOIN field_data_field_class b ON (p.item_id = b.entity_id)

SELECT bundle, entity_id, COUNT(*) FROM field_data_pp_body GROUP BY bundle, entity_id
SELECT bundle, entity_id, COUNT(*) FROM field_data_field_class GROUP BY bundle, entity_id