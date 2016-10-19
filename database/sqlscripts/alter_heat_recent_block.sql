  
  alter table heat_recent_blocks
  add modelable_id int null
  
  alter table heat_recent_blocks
  add modelable_type varchar(255) null


  alter table heat_index_blocks
  add modelable_id int null
  
  alter table heat_index_blocks
  add modelable_type varchar(255) null

  alter table heat_index_blocks
 drop column at
 
 alter table heat_index_blocks
 add from_offset datetime2 
 
 alter table heat_index_blocks
 add to_offset datetime2

  alter table heat_index_blocks
 add is_time_range bit default 0


 alter table heat_recent_blocks
alter column [from] datetime2 

alter table heat_recent_blocks
alter column [to] datetime2 

alter table heat_recent_blocks
drop column is_realtime

alter table heat_recent_blocks
drop column interval

alter table heat_recent_blocks
add group_by varchar(100)

alter table dbo.heat_recent_blocks 
add is_filter_collection bit 

alter table dbo.heat_recent_blocks
add hourly_from time

alter table dbo.heat_recent_blocks
add hourly_to time

alter table dbo.heat_recent_blocks
add hourly_function_name varchar(100)

alter table dbo.heat_recent_blocks
add has_hourly_function bit