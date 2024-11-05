import { MasterItemBrandService } from '@gateway_core/master/services/master.item.brand.service'
import { MasterItemCategoryService } from '@gateway_core/master/services/master.item.category.service'
import { MasterItemService } from '@gateway_core/master/services/master.item.service'
import { MasterItemUnitService } from '@gateway_core/master/services/master.item.unit.service'
import { OnWorkerEvent, Processor, WorkerHost } from '@nestjs/bullmq'
import { Inject } from '@nestjs/common'
import { Job } from 'bullmq'
import * as CSVParser from 'csv-parse'
import * as fs from 'fs'

@Processor('master_data')
export class MasterDataConsumer extends WorkerHost {
  constructor(
    @Inject(MasterItemUnitService)
    private readonly masterItemUnitService: MasterItemUnitService,

    @Inject(MasterItemCategoryService)
    private readonly masterItemCategoryService: MasterItemCategoryService,

    @Inject(MasterItemBrandService)
    private readonly masterItemBrandService: MasterItemBrandService,

    @Inject(MasterItemService)
    private readonly masterItemService: MasterItemService
  ) {
    super()
  }
  @OnWorkerEvent('active')
  onActive(job: Job) {
    job.log(`Processing job ${job.id} of type ${job.name}...`)
  }

  async process(job: Job<any, any, string>): Promise<any> {
    switch (job.name) {
      case 'master_item':
        await this.importMasterItem(job)
        break
    }
  }

  async importMasterItem(job: Job) {
    const _this = this
    for await (const a of job.data.file) {
      fs.readFile(a.filename, function (err, fileData) {
        CSVParser.parse(
          fileData,
          { columns: true, trim: true },
          async (err, rows) => {
            if (err) {
              job.log(err.stack)
            }

            for await (const b of rows) {
              const conversion = []
              let targetCategory = {}
              let targetBrand = {}
              const code = b['code']
              const name = b['name']
              const brand = b['brand']
              const category = b['category']
              const large = b['large']
              const medium = b['medium']
              const small = b['small']
              const large_ratio = parseFloat(b['large_ratio'])
              const medium_ratio = parseFloat(b['medium_ratio'])
              const small_ratio = parseFloat(b['small_ratio'])
              const allow_sell_large = parseInt(b['allow_sell_large']) > 0
              const allow_sell_medium = parseInt(b['allow_sell_medium']) > 0
              const allow_sell_small = parseInt(b['allow_sell_small']) > 0

              // UNIT PREPARATION
              if (large && large !== '') {
                await _this.masterItemUnitService
                  .upsert(
                    {
                      name: large,
                    },
                    job.data.account
                  )
                  .then((result) => {
                    if (!isNaN(large_ratio)) {
                      conversion.push({
                        unit: result,
                        type: 'large',
                        allow_sell: allow_sell_large,
                        ratio: large_ratio,
                      })
                    }
                  })
              }

              if (medium && medium !== '') {
                await _this.masterItemUnitService
                  .upsert(
                    {
                      name: medium,
                    },
                    job.data.account
                  )
                  .then((result) => {
                    if (!isNaN(medium_ratio)) {
                      conversion.push({
                        unit: result,
                        type: 'medium',
                        allow_sell: allow_sell_medium,
                        ratio: medium_ratio,
                      })
                    }
                  })
              }

              if (small && small !== '') {
                await _this.masterItemUnitService
                  .upsert(
                    {
                      name: small,
                    },
                    job.data.account
                  )
                  .then((result) => {
                    if (!isNaN(small_ratio)) {
                      conversion.push({
                        unit: result,
                        type: 'small',
                        allow_sell: allow_sell_small,
                        ratio: small_ratio,
                      })
                    }
                  })
              }

              //CATEGORY PREPARATION
              await _this.masterItemCategoryService
                .upsert({ name: category }, job.data.account)
                .then((result) => {
                  targetCategory = result
                })

              // BRAND PREPARATION
              await _this.masterItemBrandService
                .upsert({ name: brand }, job.data.account)
                .then((result) => {
                  targetBrand = result
                })

              // ITEM PREPARATION
              if (name && name !== '') {
                await _this.masterItemService.upsert(
                  {
                    name: name,
                    code: code,
                    brand: targetBrand,
                    category: targetCategory,
                    unit_conversion: conversion,
                  },
                  job.data.account
                )
                console.log('Processing')
              }
            }
          }
        )
      })
    }
  }
}
