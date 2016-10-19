alter table TotalNetRecent
add heat_index_planned as 计划热指标

alter table TotalNetRecent
add heat_index_ref as 参考热指标

alter table TotalNetRecent
add heat_index_calculate as 核算热指标

alter table TotalNetRecent
add total_heat_inst  as 总瞬时热量

alter table TotalNetRecent
add total_water_flow_inst  as 总瞬时流量

 alter table totalNetRecent
  add flow_ten_thou as 万平方米流量


 alter table totalNetRecent
  add heat_perdict as 预计全天GJ

 alter table totalNetRecent
   add heat_planned_perdict_ratio decimal(8,4)

   alter table totalNetRecent
add heat_planned_yesterday as 昨日计划GJ

alter table totalNetRecent
add heat_actual_yesterday as 昨日累计GJ

alter table totalNetRecent
add heat_calculated_yesterday as 昨日核算GJ

alter table totalNetRecent
add heat_index_planned_yesterday as 昨日计划热指标

alter table totalNetRecent
add heat_index_actual_yesterday as 昨日实际热指标

alter table totalNetRecent
add heat_index_calculated_yesterday as 昨日核算热指标

