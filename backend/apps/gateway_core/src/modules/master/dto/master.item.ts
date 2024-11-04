import { CMasterItemBrand } from '@gateway_core/master/dto/master.item.brand'
import { CMasterItemCategory } from '@gateway_core/master/dto/master.item.category'
import { CMasterItemConfiguration } from '@gateway_core/master/dto/master.item.configuration'
import { CMasterItemStoring } from '@gateway_core/master/dto/master.item.storing'
import { CMasterItemUnitConversion } from '@gateway_core/master/dto/master.item.unit'
import { IMasterItemBrand } from '@interfaces/master.item.brand'
import { IMasterItemCategory } from '@interfaces/master.item.category'
import { IMasterItemConfiguration } from '@interfaces/master.item.configuration'
import { IMasterItemStoring } from '@interfaces/master.item.storing'
import { ApiProperty } from '@nestjs/swagger'
import { CLOV, ILOV } from '@schemas/lov/lov'
import { IMasterItemUnitConversion } from '@schemas/master/master.item.unit'
import {
  IsNotEmpty,
  IsNumber,
  IsOptional,
  IsString,
  MaxLength,
  MinLength,
  ValidateNested,
} from 'class-validator'
import { Types } from 'mongoose'

export class CMasterItem {
  @ApiProperty({
    type: String,
    example: `item-${new Types.ObjectId().toString()}`,
  })
  id: string

  @ApiProperty({
    type: String,
    example: 'XX-XX',
  })
  code: string

  @ApiProperty({
    type: String,
    example: 'Drugs',
  })
  name: string

  @ApiProperty({
    type: CMasterItemBrand,
  })
  @IsNotEmpty()
  brand: IMasterItemBrand
}

export class MasterItemAddDTO {
  @ApiProperty({
    type: String,
    example: 'xxx-xxxx',
    minLength: 8,
    maxLength: 24,
    description: 'Unique code of item',
    required: false,
  })
  @MinLength(8)
  @MaxLength(24)
  @IsString()
  code?: string

  @ApiProperty({
    type: String,
    example: 'Adidas',
    description: 'Item brand name',
  })
  @IsNotEmpty()
  name: string

  @ApiProperty({
    example: 'Adidas ALias',
    description: 'Item alias name',
    required: false,
  })
  @IsOptional()
  @IsString()
  alias?: string

  @ApiProperty({
    type: CMasterItemConfiguration,
    description: 'Stock point configuration',
  })
  @IsNotEmpty()
  configuration: IMasterItemConfiguration

  @ApiProperty({
    type: CMasterItemStoring,
    isArray: true,
    required: false,
    description: 'Storing configuration',
  })
  @IsNotEmpty()
  storing: IMasterItemStoring[]

  @ApiProperty({
    type: CMasterItemCategory,
    isArray: true,
  })
  @ValidateNested({ each: true })
  @IsNotEmpty()
  category: IMasterItemCategory[]

  @ApiProperty({
    type: CMasterItemUnitConversion,
    isArray: true,
  })
  @IsNotEmpty()
  unit_conversion: IMasterItemUnitConversion

  @ApiProperty({
    type: CMasterItemBrand,
  })
  @IsNotEmpty()
  brand: IMasterItemBrand

  @ApiProperty({
    type: CLOV,
    isArray: true,
    description: 'Stock point configuration',
    required: false,
  })
  @IsOptional()
  @IsNotEmpty()
  properties: ILOV[]

  @ApiProperty({
    example: 'Extra remark',
    description: 'Item brand extra remark',
    required: false,
  })
  @IsNotEmpty()
  @IsOptional()
  remark?: string
}

export class MasterItemEditDTO {
  @ApiProperty({
    type: String,
    example: 'xxx-xxxx',
    minLength: 8,
    maxLength: 24,
    description: 'Unique code of item',
  })
  @MinLength(8)
  @MaxLength(24)
  @IsString()
  @IsNotEmpty()
  code: string

  @ApiProperty({
    type: String,
    example: 'Adidas',
    description: 'Item brand name',
  })
  @IsNotEmpty()
  name: string

  @ApiProperty({
    example: 'Adidas ALias',
    description: 'Item alias name',
    required: false,
  })
  @IsOptional()
  @IsString()
  alias?: string

  @ApiProperty({
    type: CMasterItemConfiguration,
    description: 'Stock point configuration',
  })
  @IsNotEmpty()
  configuration: IMasterItemConfiguration

  @ApiProperty({
    type: CMasterItemStoring,
    isArray: true,
    required: false,
    description: 'Storing configuration',
  })
  @IsNotEmpty()
  storing: IMasterItemStoring[]

  @ApiProperty({
    type: CMasterItemCategory,
    isArray: true,
  })
  @ValidateNested({ each: true })
  @IsNotEmpty()
  category: IMasterItemCategory[]

  @ApiProperty({
    type: CMasterItemUnitConversion,
    isArray: true,
  })
  @IsNotEmpty()
  unit_conversion: IMasterItemUnitConversion

  @ApiProperty({
    type: CMasterItemBrand,
  })
  @IsNotEmpty()
  brand: IMasterItemBrand

  @ApiProperty({
    type: CLOV,
    isArray: true,
    description: 'Stock point configuration',
    required: false,
  })
  @IsOptional()
  @IsNotEmpty()
  properties: ILOV[]

  @ApiProperty({
    example: 'Extra remark',
    description: 'Item brand extra remark',
    required: false,
  })
  @IsNotEmpty()
  @IsOptional()
  remark?: string

  @ApiProperty({
    example: 0,
    description: 'Item brand document version',
  })
  @IsNotEmpty()
  @IsNumber()
  __v: number
}
