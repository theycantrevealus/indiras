import { IAccountCreatedBy } from '@gateway_core/account/interface/account.create_by'
import {
  MasterItemUnitAddDTO,
  MasterItemUnitEditDTO,
} from '@gateway_core/master/dto/master.item.unit'
import { IMasterItemUnit } from '@interfaces/master.item.unit'
import { HttpStatus, Inject, Injectable } from '@nestjs/common'
import { ConfigService } from '@nestjs/config'
import { InjectModel } from '@nestjs/mongoose'
import {
  MasterItemUnit,
  MasterItemUnitDocument,
} from '@schemas/master/master.item.unit'
import { PrimeParameter } from '@utility/dto/prime'
import { GlobalResponse } from '@utility/dto/response'
import { modCodes } from '@utility/modules'
import prime_datatable from '@utility/prime'
import { TimeManagement } from '@utility/time'
import { Model } from 'mongoose'

@Injectable()
export class MasterItemUnitService {
  constructor(
    @Inject(ConfigService) private readonly configService: ConfigService,

    @InjectModel(MasterItemUnit.name, 'primary')
    private masterItemUnitModel: Model<MasterItemUnitDocument>
  ) {}

  async all(payload: any) {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_UNIT_LIST',
      transaction_id: null,
    } satisfies GlobalResponse

    try {
      const parameter: PrimeParameter = JSON.parse(payload)
      return await prime_datatable(parameter, this.masterItemUnitModel).then(
        (result) => {
          response.payload = result.payload
          response.message = 'Master item unit fetch successfully'
          return response
        }
      )
    } catch (error) {
      response.message = `Master item unit failed to fetch`
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async detail(id: string): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_UNIT_GET',
      transaction_id: id,
    } satisfies GlobalResponse

    try {
      return await this.masterItemUnitModel
        .findOne({ id: id })
        .then((result) => {
          response.payload = result
          response.message = 'Master item unit detail fetch successfully'
          return response
        })
    } catch (error) {
      response.message = `Master item unit detail failed to fetch`
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async find(term: any): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_UNIT_GET',
      transaction_id: '',
    } satisfies GlobalResponse

    try {
      return await this.masterItemUnitModel.findOne(term).then((result) => {
        response.payload = result
        response.message = 'Master item unit detail fetch successfully'
        return response
      })
    } catch (error) {
      response.message = `Master item unit detail failed to fetch`
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async upsert(
    term: any,
    account: IAccountCreatedBy
  ): Promise<IMasterItemUnit> {
    return await this.masterItemUnitModel
      .findOne({
        name: term.name,
      })
      .then(async (result) => {
        if (result) {
          return result
        } else {
          return await this.add(
            {
              name: term.name,
              remark: 'Auto Generated Unit',
            },
            account
          ).then((addResult) => {
            return addResult.payload as IMasterItemUnit
          })
        }
      })
  }

  async add(
    data: MasterItemUnitAddDTO,
    account: IAccountCreatedBy
  ): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_UNIT_ADD',
      transaction_id: null,
    } satisfies GlobalResponse

    if (!data.code) {
      data.code = `${modCodes[this.constructor.name].defaultCode}-${new Date().getTime()}`
    }

    try {
      return await this.masterItemUnitModel
        .create({
          ...data,
          created_by: account,
        })
        .then((result: IMasterItemUnit) => {
          response.message = 'Master item unit created successfully'
          response.transaction_id = result.id
          response.payload = result
          return response
        })
    } catch (error) {
      response.message = `Master item unit failed to create. ${error.message}`
      response.statusCode = modCodes[this.constructor.name].error.databaseError
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async edit(data: MasterItemUnitEditDTO, id: string): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_UNIT_EDIT',
      transaction_id: null,
    } satisfies GlobalResponse

    try {
      return await this.masterItemUnitModel
        .findOneAndUpdate(
          {
            id: id,
            __v: data.__v,
          },
          {
            code: data.code,
            name: data.name,
            remark: data.remark,
          }
        )
        .then((result) => {
          response.message = 'Master item unit updated successfully'
          response.payload = result
          return response
        })
    } catch (error) {
      response.message = `Master item unit failed to update. ${error.message}`
      response.statusCode = modCodes[this.constructor.name].error.databaseError
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async delete(id: string): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_UNIT_DELETE',
      transaction_id: null,
    } satisfies GlobalResponse

    try {
      return await this.masterItemUnitModel
        .findOneAndUpdate(
          {
            id: id,
          },
          {
            deleted_at: new TimeManagement().getTimezone(
              await this.configService.get<string>('application.timezone')
            ),
          }
        )
        .then(async () => {
          response.message = 'Master item unit deleted successfully'
          return response
        })
    } catch (error) {
      response.message = 'Master item unit failed to delete'
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }
}
