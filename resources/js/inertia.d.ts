export type InertiaProps = {
  [key: string]: unknown
} & {
  auth: {
    user: {
      id: number
      name: string
      email: string
      created_at: Date
      updated_at: Date
      email_verified_at: Date | null
      current_team_id: number | null
      profile_photo_path: string | null
      profile_photo_url: string | null
      two_factor_confirmed_at: Date | null
      two_factor_enabled: boolean
    }
  }
  jetstream: {
    flash: unknown[]
    [key: string]: boolean | unknown[]
  }
  errorBags: unknown
  errors: unknown
}
