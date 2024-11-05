import { IMasterItemUnit } from '@interfaces/master.item.unit'
import { ApiProperty } from '@nestjs/swagger'
import {
  IsBoolean,
  IsNotEmpty,
  IsNumber,
  IsOptional,
  MaxLength,
  MinLength,
} from 'class-validator'
import { Types } from 'mongoose'

export class CMasterItemUnit {
  @ApiProperty({
    type: String,
    example: `item_unit-${new Types.ObjectId().toString()}`,
  })
  id: string

  @ApiProperty({
    type: String,
    example: 'XX-XX',
  })
  code: string

  @ApiProperty({
    type: String,
    example: 'Ampole',
  })
  name: string
}

export class CMasterItemUnitConversion {
  @ApiProperty({
    type: CMasterItemUnit,
    description: 'From unit conversion',
  })
  @IsNotEmpty()
  unit: IMasterItemUnit

  @ApiProperty({
    example: 'large',
    description: 'Type of unit',
    enum: ['large', 'medium', 'small'],
    required: true,
  })
  @IsOptional()
  @IsNotEmpty()
  @IsBoolean()
  type: string

  @ApiProperty({
    description: 'Is it allowed to sell',
    required: true,
    default: false,
  })
  @IsOptional()
  @IsNotEmpty()
  @IsBoolean()
  allow_sell: boolean

  @ApiProperty({
    example: '40',
    description: 'Ratio from:to. from is always 1',
    required: true,
  })
  @IsOptional()
  @IsNotEmpty()
  @IsNumber()
  ratio?: number
}

export class MasterItemUnitAddDTO {
  @ApiProperty({
    example: 'xxx-xxxx',
    minLength: 8,
    maxLength: 24,
    description: 'Unique code of item unit',
    required: false,
  })
  @MinLength(8)
  @MaxLength(24)
  code?: string

  @ApiProperty({
    example: 'Capsule',
    description: 'Item unit name',
  })
  @IsNotEmpty()
  name: string

  @ApiProperty({
    example: 'Extra remark',
    description: 'Item unit extra remark',
    required: false,
  })
  @IsOptional()
  @IsNotEmpty()
  remark?: string
}

export class MasterItemUnitEditDTO {
  @ApiProperty({
    example: 'xxx-xxxx',
    minLength: 8,
    maxLength: 24,
    description: 'Unique code of item unit',
  })
  @MinLength(8)
  @MaxLength(24)
  @IsNotEmpty()
  code: string

  @ApiProperty({
    example: 'Capsule',
    description: 'Item unit name',
  })
  @IsNotEmpty()
  name: string

  @ApiProperty({
    example: 'Extra remark',
    description: 'Item unit extra remark',
    required: false,
  })
  @IsNotEmpty()
  @IsOptional()
  remark?: string

  @ApiProperty({
    example: 0,
    description: 'Item unit document version',
  })
  @IsNotEmpty()
  @IsNumber()
  __v: number
}
